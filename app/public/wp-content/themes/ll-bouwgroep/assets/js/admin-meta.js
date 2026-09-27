/**
 * Admin meta box interactions (vanilla JS + wp.media).
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

	/**
	 * Binds image field controls.
	 *
	 * @param {HTMLElement} root Root element.
	 */
	function bindImageField(root) {
		var input = root.querySelector('.llb-meta-image__input');
		var preview = root.querySelector('.llb-meta-image__preview');
		var selectBtn = root.querySelector('.llb-meta-image__select');
		var removeBtn = root.querySelector('.llb-meta-image__remove');
		var frame;

		if (!input || !selectBtn) {
			return;
		}

		selectBtn.addEventListener('click', function (event) {
			event.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: selectBtn.textContent,
				button: { text: selectBtn.textContent },
				multiple: false
			});

			frame.on('select', function () {
				var attachment = frame.state().get('selection').first().toJSON();
				var url = attachment.sizes && attachment.sizes.thumbnail
					? attachment.sizes.thumbnail.url
					: attachment.url;

				input.value = String(attachment.id);
				preview.innerHTML = '';
				var img = document.createElement('img');
				img.src = url;
				img.alt = '';
				img.className = 'llb-meta-thumb';
				preview.appendChild(img);
				if (removeBtn) {
					removeBtn.hidden = false;
				}
			});

			frame.open();
		});

		if (removeBtn) {
			removeBtn.addEventListener('click', function (event) {
				event.preventDefault();
				input.value = '';
				preview.innerHTML = '';
				removeBtn.hidden = true;
			});
		}
	}

	/**
	 * Creates a gallery list item.
	 *
	 * @param {string} name Field name.
	 * @param {Object} attachment Media attachment JSON.
	 * @return {HTMLLIElement}
	 */
	function createGalleryItem(name, attachment) {
		var li = document.createElement('li');
		li.className = 'llb-meta-gallery__item';
		li.draggable = true;
		li.dataset.id = String(attachment.id);

		var url = attachment.sizes && attachment.sizes.thumbnail
			? attachment.sizes.thumbnail.url
			: attachment.url;

		var img = document.createElement('img');
		img.src = url;
		img.alt = '';
		img.className = 'llb-meta-thumb';
		li.appendChild(img);

		var hidden = document.createElement('input');
		hidden.type = 'hidden';
		hidden.name = name + '[]';
		hidden.value = String(attachment.id);
		li.appendChild(hidden);

		var remove = document.createElement('button');
		remove.type = 'button';
		remove.className = 'button-link llb-meta-gallery__remove';
		remove.setAttribute('aria-label', 'Remove image');
		remove.textContent = '×';
		li.appendChild(remove);

		return li;
	}

	/**
	 * Binds gallery field controls.
	 *
	 * @param {HTMLElement} root Root element.
	 */
	function bindGalleryField(root) {
		var list = root.querySelector('.llb-meta-gallery__list');
		var addBtn = root.querySelector('.llb-meta-gallery__add');
		var name = root.getAttribute('data-name') || '';
		var frame;
		var dragItem = null;

		if (!list || !addBtn) {
			return;
		}

		addBtn.addEventListener('click', function (event) {
			event.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: addBtn.textContent,
				button: { text: addBtn.textContent },
				multiple: true
			});

			frame.on('select', function () {
				frame.state().get('selection').each(function (model) {
					var attachment = model.toJSON();
					list.appendChild(createGalleryItem(name, attachment));
				});
			});

			frame.open();
		});

		list.addEventListener('click', function (event) {
			var target = event.target;
			if (target && target.classList.contains('llb-meta-gallery__remove')) {
				event.preventDefault();
				var item = target.closest('.llb-meta-gallery__item');
				if (item) {
					item.remove();
				}
			}
		});

		list.addEventListener('dragstart', function (event) {
			var item = event.target.closest('.llb-meta-gallery__item');
			if (!item) {
				return;
			}
			dragItem = item;
			item.classList.add('is-dragging');
			event.dataTransfer.effectAllowed = 'move';
		});

		list.addEventListener('dragend', function () {
			if (dragItem) {
				dragItem.classList.remove('is-dragging');
			}
			dragItem = null;
		});

		list.addEventListener('dragover', function (event) {
			event.preventDefault();
			var target = event.target.closest('.llb-meta-gallery__item');
			if (!dragItem || !target || target === dragItem) {
				return;
			}
			var rect = target.getBoundingClientRect();
			var after = (event.clientX - rect.left) > (rect.width / 2);
			list.insertBefore(dragItem, after ? target.nextSibling : target);
		});
	}

	/**
	 * Reindexes repeater row input names after add/remove/reorder.
	 *
	 * @param {HTMLElement} root Repeater root.
	 */
	function reindexRepeater(root) {
		var name = root.getAttribute('data-name') || '';
		var rows = root.querySelectorAll('[data-llb-repeater-row]');

		rows.forEach(function (row, index) {
			row.querySelectorAll('[name]').forEach(function (input) {
				var current = input.getAttribute('name') || '';
				var updated = current.replace(
					new RegExp('^' + name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\[(?:__INDEX__|\\d+)\\]'),
					name + '[' + index + ']'
				);
				input.setAttribute('name', updated);

				if (input.id) {
					input.id = 'llb-field-' + updated.replace(/[\[\]]/g, '-');
				}
			});
		});
	}

	/**
	 * Binds repeater field controls.
	 *
	 * @param {HTMLElement} root Root element.
	 */
	function bindRepeaterField(root) {
		var rowsWrap = root.querySelector('.llb-meta-repeater__rows');
		var template = root.querySelector('.llb-meta-repeater__template');
		var addBtn = root.querySelector('.llb-meta-repeater__add');

		if (!rowsWrap || !template || !addBtn) {
			return;
		}

		addBtn.addEventListener('click', function (event) {
			event.preventDefault();
			var html = template.innerHTML;
			var wrapper = document.createElement('div');
			wrapper.innerHTML = html.trim();
			var row = wrapper.firstElementChild;
			if (!row) {
				return;
			}
			rowsWrap.appendChild(row);
			reindexRepeater(root);
		});

		root.addEventListener('click', function (event) {
			var target = event.target;
			var row = target.closest('[data-llb-repeater-row]');
			if (!row || !rowsWrap.contains(row)) {
				return;
			}

			if (target.classList.contains('llb-meta-repeater__remove')) {
				event.preventDefault();
				row.remove();
				if (!rowsWrap.querySelector('[data-llb-repeater-row]')) {
					addBtn.click();
				}
				reindexRepeater(root);
				return;
			}

			if (target.classList.contains('llb-meta-repeater__up')) {
				event.preventDefault();
				if (row.previousElementSibling) {
					rowsWrap.insertBefore(row, row.previousElementSibling);
					reindexRepeater(root);
				}
				return;
			}

			if (target.classList.contains('llb-meta-repeater__down')) {
				event.preventDefault();
				if (row.nextElementSibling) {
					rowsWrap.insertBefore(row.nextElementSibling, row);
					reindexRepeater(root);
				}
			}
		});
	}

	function init() {
		if (typeof wp === 'undefined' || !wp.media) {
			return;
		}

		document.querySelectorAll('[data-llb-image]').forEach(bindImageField);
		document.querySelectorAll('[data-llb-gallery]').forEach(bindGalleryField);
		document.querySelectorAll('[data-llb-repeater]').forEach(bindRepeaterField);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
