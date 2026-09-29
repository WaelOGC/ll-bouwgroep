/**
 * Main theme script.
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

	document.documentElement.classList.add('llb-js');

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var animationsOn = !(window.llbTheme && String(window.llbTheme.animations) === '0');
	if (!reduceMotion && animationsOn) {
		document.body.classList.add('llb-motion');
	}

	/* Header scroll + mobile menu (design v2) */
	var hdr = document.getElementById('hdr');
	var burger = document.getElementById('burger');
	var mnav = document.getElementById('mnav');
	var root = document.documentElement;

	function setScrolled() {
		if (!hdr) {
			return;
		}
		hdr.classList.toggle('scrolled', window.scrollY > 8);
	}

	setScrolled();
	window.addEventListener('scroll', setScrolled, { passive: true });

	if (burger && mnav) {
		burger.addEventListener('click', function () {
			var open = root.classList.toggle('menu-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			burger.setAttribute('aria-label', open ? 'Menu sluiten' : 'Menu openen');
			document.body.style.overflow = open ? 'hidden' : '';
		});

		mnav.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				root.classList.remove('menu-open');
				document.body.style.overflow = '';
				burger.setAttribute('aria-expanded', 'false');
				burger.setAttribute('aria-label', 'Menu openen');
			});
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && root.classList.contains('menu-open')) {
				root.classList.remove('menu-open');
				document.body.style.overflow = '';
				burger.setAttribute('aria-expanded', 'false');
				burger.setAttribute('aria-label', 'Menu openen');
				burger.focus();
			}
		});

		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 1024px)').matches && root.classList.contains('menu-open')) {
				root.classList.remove('menu-open');
				document.body.style.overflow = '';
				burger.setAttribute('aria-expanded', 'false');
			}
		});
	}

	if (mnav) {
		mnav.querySelectorAll(':scope > ul > .menu-item-has-children').forEach(function (li) {
			var link = li.querySelector(':scope > a');
			if (!link || li.querySelector(':scope > .mnav-toggle')) {
				return;
			}
			var toggle = document.createElement('button');
			toggle.type = 'button';
			toggle.className = 'mnav-toggle';
			toggle.setAttribute('aria-expanded', 'false');
			toggle.setAttribute('aria-label', 'Submenu openen');
			link.insertAdjacentElement('afterend', toggle);

			var startOpen =
				li.classList.contains('current-menu-ancestor') ||
				li.classList.contains('current-menu-parent') ||
				li.querySelector(':scope > .sub-menu .current-menu-item, :scope > .sub-menu .current_page_item');
			if (!startOpen) {
				var pagePath = window.location.pathname.replace(/\/$/, '') || '/';
				li.querySelectorAll(':scope > .sub-menu a[href]').forEach(function (subLink) {
					if (startOpen) {
						return;
					}
					try {
						var subPath = new URL(subLink.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
						if (subPath === pagePath) {
							startOpen = true;
						}
					} catch (err) {
						/* ignore malformed href */
					}
				});
			}
			if (startOpen) {
				li.classList.add('is-open');
				toggle.setAttribute('aria-expanded', 'true');
				toggle.setAttribute('aria-label', 'Submenu sluiten');
			}

			toggle.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				var open = li.classList.toggle('is-open');
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
				toggle.setAttribute('aria-label', open ? 'Submenu sluiten' : 'Submenu openen');
			});
		});
	}

	/* Home / FAQ accordion (design v2) */
	document.querySelectorAll('.qa > button').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var q = btn.parentNode;
			var open = q.classList.toggle('open');
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	});

	/* FAQ page category scroll-spy (faq-v2) */
	(function () {
		var links = [].slice.call(document.querySelectorAll('.fnav a'));
		if (!links.length || !('IntersectionObserver' in window)) {
			return;
		}
		var map = {};
		links.forEach(function (a) {
			map[a.getAttribute('href').slice(1)] = a;
		});
		var io = new IntersectionObserver(
			function (es) {
				es.forEach(function (e) {
					if (e.isIntersecting) {
						links.forEach(function (l) {
							l.removeAttribute('aria-current');
						});
						var a = map[e.target.id];
						a.setAttribute('aria-current', 'true');
						if (innerWidth < 1024) {
							a.scrollIntoView({ block: 'nearest', inline: 'center' });
						}
					}
				});
			},
			{ rootMargin: '-30% 0px -60% 0px' }
		);
		document.querySelectorAll('.fcat').forEach(function (s) {
			io.observe(s);
		});
	})();

	/* Image reveal (.rv) — hidden only after llb-js + llb-motion */
	var rvs = document.querySelectorAll('.rv');

	function revealRv(el) {
		el.classList.add('in');
	}

	function rvInViewport(el) {
		var rect = el.getBoundingClientRect();
		var vh = window.innerHeight || document.documentElement.clientHeight;
		return rect.bottom > 0 && rect.top < vh;
	}

	if (!reduceMotion && animationsOn && 'IntersectionObserver' in window && rvs.length) {
		rvs.forEach(function (el) {
			if (rvInViewport(el)) {
				revealRv(el);
			}
		});

		var rvObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						revealRv(entry.target);
						rvObserver.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0, rootMargin: '0px 0px -10% 0px' }
		);

		rvs.forEach(function (el) {
			if (!el.classList.contains('in')) {
				rvObserver.observe(el);
			}
		});

		window.setTimeout(function () {
			rvs.forEach(function (el) {
				revealRv(el);
				rvObserver.unobserve(el);
			});
		}, 2500);
	} else {
		rvs.forEach(revealRv);
	}

	/* Legacy scroll reveal (inner pages) */
	var reveals = document.querySelectorAll('.llb-reveal');
	if (!reduceMotion && animationsOn && 'IntersectionObserver' in window && reveals.length) {
		document.documentElement.classList.add('llb-js-reveal');
		var revealObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						revealObserver.unobserve(entry.target);
					}
				});
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
		);
		reveals.forEach(function (el) {
			revealObserver.observe(el);
		});
	} else {
		reveals.forEach(function (el) {
			el.classList.add('is-visible');
		});
	}

	/* Project gallery (single project — matches project-v2.html) */
	(function initProjectGallery() {
		var g = document.querySelector('.gallery[data-srcs]');
		if (!g) {
			return;
		}
		var s;
		try {
			s = JSON.parse(g.getAttribute('data-srcs'));
		} catch (err) {
			return;
		}
		if (!Array.isArray(s) || s.length < 2) {
			return;
		}
		var i = 0;
		var img = document.getElementById('galImg');
		var n = document.getElementById('galN');
		var th = [].slice.call(g.querySelectorAll('.gal-thumbs button'));
		if (!img || !n) {
			return;
		}
		function go(k) {
			i = (k + s.length) % s.length;
			img.style.opacity = 0;
			setTimeout(function () {
				img.src = s[i];
				img.style.opacity = 1;
			}, 180);
			n.textContent = String(i + 1);
			th.forEach(function (b, j) {
				if (j === i) {
					b.setAttribute('aria-current', 'true');
				} else {
					b.removeAttribute('aria-current');
				}
			});
			if (th[i] && typeof th[i].scrollIntoView === 'function') {
				th[i].scrollIntoView({ block: 'nearest', inline: 'center' });
			}
		}
		g.querySelectorAll('.gal-btn').forEach(function (b) {
			b.addEventListener('click', function () {
				go(i + +b.getAttribute('data-dir'));
			});
		});
		th.forEach(function (b, j) {
			b.addEventListener('click', function () {
				go(j);
			});
		});
		var x0 = null;
		img.addEventListener(
			'touchstart',
			function (e) {
				x0 = e.touches[0].clientX;
			},
			{ passive: true }
		);
		img.addEventListener('touchend', function (e) {
			if (x0 === null) {
				return;
			}
			var d = e.changedTouches[0].clientX - x0;
			if (Math.abs(d) > 40) {
				go(i + (d < 0 ? 1 : -1));
			}
			x0 = null;
		});
	})();

	/* Announcement bar close (remembered per message) */
	(function initAnnouncement() {
		var bar = document.getElementById('llb-announce');
		if (!bar) {
			return;
		}
		var key = bar.getAttribute('data-llb-announce');
		var close = bar.querySelector('[data-llb-announce-close]');
		if (!close) {
			return;
		}
		close.addEventListener('click', function () {
			bar.hidden = true;
			try {
				window.localStorage.setItem(key, '1');
			} catch (err) {
				/* Storage unavailable (private mode): the bar simply returns next visit. */
			}
		});
	})();

	/* Back to top */
	(function initBackToTop() {
		var btn = document.getElementById('llb-back-to-top');
		if (!btn) {
			return;
		}

		var threshold = 600;

		function toggle() {
			btn.hidden = window.scrollY < threshold;
		}

		toggle();
		window.addEventListener('scroll', toggle, { passive: true });

		btn.addEventListener('click', function () {
			var smooth = !reduceMotion && animationsOn;
			window.scrollTo({ top: 0, behavior: smooth ? 'smooth' : 'auto' });
		});
	})();

	/* Text page TOC scroll-spy (privacy / default page) */
	(function initTocSpy() {
		var links = [].slice.call(document.querySelectorAll('.toc a'));
		if (!links.length || !('IntersectionObserver' in window)) {
			return;
		}
		var map = {};
		links.forEach(function (a) {
			var href = a.getAttribute('href') || '';
			if (href.charAt(0) === '#') {
				map[href.slice(1)] = a;
			}
		});
		var io = new IntersectionObserver(
			function (es) {
				es.forEach(function (e) {
					if (!e.isIntersecting) {
						return;
					}
					links.forEach(function (l) {
						l.removeAttribute('aria-current');
					});
					if (map[e.target.id]) {
						map[e.target.id].setAttribute('aria-current', 'true');
					}
				});
			},
			{ rootMargin: '-20% 0px -70% 0px' }
		);
		document.querySelectorAll('.prose h2[id]').forEach(function (h) {
			io.observe(h);
		});
	})();

	/* CF7 custom select (progressive enhancement) */
	(function initCf7CustomSelect() {
		var selectUid = 0;

		function placeholderLabel(select) {
			return select.options.length ? select.options[0].textContent : '';
		}

		function updateBtn(btn, select) {
			var ph = placeholderLabel(select);
			if (!select.value) {
				btn.textContent = ph;
				btn.classList.add('is-placeholder');
			} else {
				var opt = select.options[select.selectedIndex];
				btn.textContent = opt ? opt.textContent : ph;
				btn.classList.remove('is-placeholder');
			}
		}

		function syncInvalid(root) {
			var select = root.querySelector('select');
			if (select) {
				root.classList.toggle('is-invalid', select.classList.contains('wpcf7-not-valid'));
			}
		}

		function optionNodes(root) {
			return [].slice.call(root.querySelectorAll('.llb-select__list [role="option"]'));
		}

		function setActive(root, li) {
			optionNodes(root).forEach(function (node) {
				node.classList.remove('is-active');
			});
			var list = root.querySelector('.llb-select__list');
			if (li) {
				li.classList.add('is-active');
				list.setAttribute('aria-activedescendant', li.id);
			} else {
				list.removeAttribute('aria-activedescendant');
			}
		}

		function updateSelected(root) {
			var select = root.querySelector('select');
			optionNodes(root).forEach(function (li) {
				var selected = li.dataset.value === select.value;
				li.setAttribute('aria-selected', selected ? 'true' : 'false');
			});
		}

		function closeSelect(root, focusBtn) {
			if (!root.classList.contains('is-open')) {
				return;
			}
			root.classList.remove('is-open');
			var btn = root.querySelector('.llb-select__btn');
			var list = root.querySelector('.llb-select__list');
			btn.setAttribute('aria-expanded', 'false');
			list.hidden = true;
			setActive(root, null);
			if (focusBtn) {
				btn.focus();
			}
		}

		function openSelect(root) {
			root.classList.add('is-open');
			var btn = root.querySelector('.llb-select__btn');
			var list = root.querySelector('.llb-select__list');
			btn.setAttribute('aria-expanded', 'true');
			list.hidden = false;
			var active =
				optionNodes(root).find(function (li) {
					return li.getAttribute('aria-selected') === 'true';
				}) || optionNodes(root)[0];
			setActive(root, active || null);
		}

		function choose(root, value) {
			var select = root.querySelector('select');
			var btn = root.querySelector('.llb-select__btn');
			select.value = value;
			select.dispatchEvent(new Event('change', { bubbles: true }));
			updateBtn(btn, select);
			updateSelected(root);
			root.classList.remove('is-invalid');
			closeSelect(root, true);
		}

		function enhanceSelect(select) {
			if (!select.classList.contains('wpcf7-select') || select.closest('.llb-select')) {
				return;
			}

			selectUid += 1;
			var uid = 'llb-select-' + selectUid;
			var root = document.createElement('div');
			root.className = 'llb-select';
			select.parentNode.insertBefore(root, select);
			root.appendChild(select);
			select.classList.add('llb-select__native');
			select.tabIndex = -1;
			select.setAttribute('aria-hidden', 'true');

			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'llb-select__btn';
			btn.id = uid + '-btn';
			btn.setAttribute('aria-haspopup', 'listbox');
			btn.setAttribute('aria-expanded', 'false');
			updateBtn(btn, select);

			var list = document.createElement('ul');
			list.className = 'llb-select__list';
			list.setAttribute('role', 'listbox');
			list.setAttribute('aria-labelledby', btn.id);
			list.hidden = true;

			[].forEach.call(select.options, function (opt, index) {
				if (!opt.value) {
					return;
				}
				var li = document.createElement('li');
				li.className = 'llb-select__option';
				li.id = uid + '-opt-' + index;
				li.setAttribute('role', 'option');
				li.dataset.value = opt.value;
				li.textContent = opt.textContent;
				li.setAttribute('aria-selected', select.value === opt.value ? 'true' : 'false');
				list.appendChild(li);
			});

			root.appendChild(btn);
			root.appendChild(list);

			root.addEventListener('click', function (e) {
				e.preventDefault();
			});

			btn.addEventListener('click', function () {
				if (root.classList.contains('is-open')) {
					closeSelect(root, false);
				} else {
					openSelect(root);
				}
			});

			list.addEventListener('click', function (e) {
				var li = e.target.closest('[role="option"]');
				if (li && root.contains(li)) {
					choose(root, li.dataset.value);
				}
			});

			btn.addEventListener('keydown', function (e) {
				var opts = optionNodes(root);
				var activeIndex = opts.findIndex(function (li) {
					return li.classList.contains('is-active');
				});

				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					if (!root.classList.contains('is-open')) {
						openSelect(root);
					} else if (activeIndex >= 0) {
						choose(root, opts[activeIndex].dataset.value);
					}
					return;
				}
				if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
					e.preventDefault();
					if (!root.classList.contains('is-open')) {
						openSelect(root);
						return;
					}
					if (!opts.length) {
						return;
					}
					var next = activeIndex;
					if (e.key === 'ArrowDown') {
						next = activeIndex < 0 ? 0 : Math.min(activeIndex + 1, opts.length - 1);
					} else {
						next = activeIndex < 0 ? opts.length - 1 : Math.max(activeIndex - 1, 0);
					}
					setActive(root, opts[next]);
					opts[next].scrollIntoView({ block: 'nearest' });
					return;
				}
				if (e.key === 'Home' && root.classList.contains('is-open')) {
					e.preventDefault();
					setActive(root, opts[0]);
					opts[0].scrollIntoView({ block: 'nearest' });
					return;
				}
				if (e.key === 'End' && root.classList.contains('is-open')) {
					e.preventDefault();
					setActive(root, opts[opts.length - 1]);
					opts[opts.length - 1].scrollIntoView({ block: 'nearest' });
					return;
				}
				if (e.key === 'Escape') {
					closeSelect(root, true);
					return;
				}
				if (e.key === 'Tab') {
					closeSelect(root, false);
				}
			});

			select.addEventListener('change', function () {
				updateBtn(btn, select);
				updateSelected(root);
				root.classList.remove('is-invalid');
			});
		}

		function enhanceAll() {
			document.querySelectorAll('select.wpcf7-select').forEach(enhanceSelect);
		}

		enhanceAll();

		document.addEventListener('click', function (e) {
			document.querySelectorAll('.llb-select.is-open').forEach(function (root) {
				if (!root.contains(e.target)) {
					closeSelect(root, false);
				}
			});
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				document.querySelectorAll('.llb-select.is-open').forEach(function (root) {
					closeSelect(root, true);
				});
			}
		});

		function syncFormInvalid(form) {
			if (!form || !form.querySelectorAll) {
				return;
			}
			form.querySelectorAll('.llb-select').forEach(syncInvalid);
		}

		document.addEventListener('wpcf7invalid', function (e) {
			requestAnimationFrame(function () {
				syncFormInvalid(e.target);
			});
		});
		document.addEventListener('wpcf7submit', function (e) {
			requestAnimationFrame(function () {
				syncFormInvalid(e.target);
			});
		});
		document.addEventListener('wpcf7mailsent', function (e) {
			var form = e.target;
			if (!form) {
				return;
			}
			form.querySelectorAll('.llb-select').forEach(function (root) {
				var select = root.querySelector('select');
				var btn = root.querySelector('.llb-select__btn');
				if (select && btn) {
					updateBtn(btn, select);
				}
				root.classList.remove('is-invalid');
				closeSelect(root, false);
			});
		});
	})();
})();
