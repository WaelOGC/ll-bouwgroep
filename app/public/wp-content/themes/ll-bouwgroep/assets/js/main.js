/**
 * Main theme script.
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	var header = document.querySelector('[data-llb-header]');
	var toggle = document.querySelector('[data-llb-nav-toggle]');
	var panel = document.querySelector('[data-llb-nav-panel]');
	var label = document.querySelector('[data-llb-nav-label]');
	var openLabel = 'Menu openen';
	var closeLabel = 'Menu sluiten';

	function setScrolled() {
		if (!header) {
			return;
		}
		if (window.scrollY > 8) {
			header.classList.add('is-scrolled');
		} else {
			header.classList.remove('is-scrolled');
		}
	}

	function isOpen() {
		return toggle && toggle.getAttribute('aria-expanded') === 'true';
	}

	function openNav() {
		if (!toggle || !panel) {
			return;
		}
		toggle.setAttribute('aria-expanded', 'true');
		panel.classList.add('is-open');
		panel.removeAttribute('hidden');
		document.body.classList.add('llb-nav-open');
		if (label) {
			label.textContent = closeLabel;
		}
	}

	function closeNav() {
		if (!toggle || !panel) {
			return;
		}
		toggle.setAttribute('aria-expanded', 'false');
		panel.classList.remove('is-open');
		panel.setAttribute('hidden', '');
		document.body.classList.remove('llb-nav-open');
		if (label) {
			label.textContent = openLabel;
		}
	}

	function toggleNav() {
		if (isOpen()) {
			closeNav();
		} else {
			openNav();
		}
	}

	setScrolled();
	window.addEventListener('scroll', setScrolled, { passive: true });

	if (toggle && panel) {
		toggle.addEventListener('click', function () {
			toggleNav();
		});

		panel.addEventListener('click', function (event) {
			var link = event.target.closest('a');
			if (link) {
				closeNav();
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && isOpen()) {
				closeNav();
				toggle.focus();
			}
		});

		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 1024px)').matches && isOpen()) {
				closeNav();
			}
		});
	}

	/* Scroll reveal */
	var reveals = document.querySelectorAll('.llb-reveal');
	if (!reduceMotion && 'IntersectionObserver' in window && reveals.length) {
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

	/* Services carousel — snap to whole cards, one card per prev/next */
	function initServicesCarousel(root) {
		var track = root.querySelector('[data-llb-carousel-track]');
		var list = track ? track.querySelector('.llb-services-carousel__list') : null;
		var prevBtn = root.querySelector('[data-llb-carousel-prev]');
		var nextBtn = root.querySelector('[data-llb-carousel-next]');

		if (!track || !list) {
			return;
		}

		var offset = 0;
		var stepping = false;
		var originals = list.querySelectorAll('.llb-services-carousel__item:not([aria-hidden="true"])');
		var setCount = originals.length;

		if (!setCount) {
			return;
		}

		function gapSize() {
			var styles = window.getComputedStyle(list);
			return parseFloat(styles.columnGap || styles.gap) || 0;
		}

		function cardStep() {
			var first = originals[0];
			if (!first) {
				return 0;
			}
			return first.getBoundingClientRect().width + gapSize();
		}

		function setWidth() {
			var step = cardStep();
			return step * setCount;
		}

		function applyTransform(animate) {
			list.style.transition = animate ? 'transform 0.4s ease' : 'none';
			list.style.transform = 'translateX(' + -offset + 'px)';
		}

		function snapToCard() {
			var step = cardStep();
			if (step <= 0) {
				return;
			}
			offset = Math.round(offset / step) * step;
			normalize(true);
		}

		function normalize(silent) {
			var width = setWidth();
			if (width <= 0) {
				return;
			}
			var changed = false;
			while (offset >= width) {
				offset -= width;
				changed = true;
			}
			while (offset < 0) {
				offset += width;
				changed = true;
			}
			if (changed || silent) {
				applyTransform(false);
			}
		}

		function stepBy(dir) {
			var step = cardStep();
			if (step <= 0 || stepping) {
				return;
			}
			stepping = true;
			offset += dir * step;
			applyTransform(true);

			window.setTimeout(function () {
				normalize(true);
				stepping = false;
			}, 420);
		}

		root.classList.add('is-js-carousel');

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				stepBy(-1);
			});
		}
		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
				stepBy(1);
			});
		}

		window.addEventListener('resize', function () {
			snapToCard();
		});

		applyTransform(false);
	}

	document.querySelectorAll('[data-llb-services-carousel]').forEach(initServicesCarousel);

	/* Gallery slider */
	function initGallerySlider(root) {
		if (root.hasAttribute('data-llb-gallery-static')) {
			return;
		}

		var slides = root.querySelectorAll('[data-llb-gallery-slide]');
		var thumbs = root.querySelectorAll('[data-llb-gallery-thumb]');
		var prevBtn = root.querySelector('[data-llb-gallery-prev]');
		var nextBtn = root.querySelector('[data-llb-gallery-next]');
		var index = 0;
		var total = slides.length;

		if (total < 2) {
			return;
		}

		function show(nextIndex) {
			index = (nextIndex + total) % total;
			slides.forEach(function (slide, i) {
				var active = i === index;
				slide.classList.toggle('is-active', active);
				if (active) {
					slide.removeAttribute('hidden');
				} else {
					slide.setAttribute('hidden', '');
				}
			});
			thumbs.forEach(function (thumb, i) {
				var active = i === index;
				thumb.classList.toggle('is-active', active);
				thumb.setAttribute('aria-current', active ? 'true' : 'false');
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				show(index - 1);
			});
		}
		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
				show(index + 1);
			});
		}

		thumbs.forEach(function (thumb) {
			thumb.addEventListener('click', function () {
				var i = parseInt(thumb.getAttribute('data-llb-gallery-thumb'), 10);
				if (!isNaN(i)) {
					show(i);
				}
			});
		});

		root.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') {
				event.preventDefault();
				show(index - 1);
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				show(index + 1);
			}
		});

		if (!root.hasAttribute('tabindex')) {
			root.setAttribute('tabindex', '0');
		}
	}

	document.querySelectorAll('[data-llb-gallery-slider]').forEach(initGallerySlider);

	/* Project filter select auto-submit */
	document.querySelectorAll('.llb-project-filter__select').forEach(function (select) {
		select.addEventListener('change', function () {
			if (select.form) {
				select.form.submit();
			}
		});
	});

	/* Motion system: body class + section decor + count-up */
	if (!reduceMotion) {
		document.body.classList.add('llb-motion');
	}

	var decorRoots = document.querySelectorAll('[data-llb-decor]');
	var canParallax = !reduceMotion && window.matchMedia('(min-width: 769px)').matches;

	if ('IntersectionObserver' in window && decorRoots.length) {
		var decorObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-inview');
					} else {
						entry.target.classList.remove('is-inview');
					}
				});
			},
			{ rootMargin: '10% 0px', threshold: 0.08 }
		);
		decorRoots.forEach(function (el) {
			decorObserver.observe(el);
		});
	} else {
		decorRoots.forEach(function (el) {
			el.classList.add('is-inview');
		});
	}

	/* Light parallax on tool pattern (CSS var so drift animation stays intact) */
	if (canParallax) {
		var parallaxItems = [];
		document.querySelectorAll('[data-llb-parallax]').forEach(function (el) {
			parallaxItems.push({
				el: el,
				section: el.closest('section')
			});
		});

		var ticking = false;
		function updateParallax() {
			ticking = false;
			var vh = window.innerHeight || 1;
			parallaxItems.forEach(function (item) {
				if (!item.section) {
					return;
				}
				var decor = item.el.closest('[data-llb-decor]');
				if (decor && !decor.classList.contains('is-inview')) {
					return;
				}
				var rect = item.section.getBoundingClientRect();
				var progress = (vh / 2 - (rect.top + rect.height / 2)) / vh;
				var offset = Math.max(-20, Math.min(20, progress * 22));
				item.el.style.setProperty('--llb-parallax-y', offset.toFixed(2) + 'px');
			});
		}

		window.addEventListener(
			'scroll',
			function () {
				if (!ticking) {
					ticking = true;
					window.requestAnimationFrame(updateParallax);
				}
			},
			{ passive: true }
		);
		updateParallax();
	}

	/* USP number count-up */
	function animateCount(el) {
		var target = parseInt(el.getAttribute('data-llb-count'), 10);
		if (isNaN(target)) {
			return;
		}
		if (reduceMotion) {
			el.textContent = String(target);
			return;
		}
		var start = null;
		var duration = 1100;
		function step(ts) {
			if (!start) {
				start = ts;
			}
			var t = Math.min(1, (ts - start) / duration);
			var eased = 1 - Math.pow(1 - t, 3);
			el.textContent = String(Math.round(target * eased));
			if (t < 1) {
				window.requestAnimationFrame(step);
			} else {
				el.textContent = String(target);
			}
		}
		el.textContent = '0';
		window.requestAnimationFrame(step);
	}

	var countEls = document.querySelectorAll('[data-llb-count]');
	if (countEls.length && 'IntersectionObserver' in window) {
		var countObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}
					var root = entry.target;
					root.querySelectorAll('[data-llb-count]').forEach(animateCount);
					countObserver.unobserve(root);
				});
			},
			{ threshold: 0.4 }
		);
		document.querySelectorAll('.llb-home-usp').forEach(function (section) {
			countObserver.observe(section);
		});
	}
})();
