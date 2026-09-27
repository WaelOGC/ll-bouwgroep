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

	/* Services carousel (JS-driven position) */
	function initServicesCarousel(root) {
		var track = root.querySelector('[data-llb-carousel-track]');
		var list = track ? track.querySelector('.llb-services-carousel__list') : null;
		var prevBtn = root.querySelector('[data-llb-carousel-prev]');
		var nextBtn = root.querySelector('[data-llb-carousel-next]');

		if (!track || !list) {
			return;
		}

		var offset = 0;
		var paused = reduceMotion;
		var stepping = false;
		var lastTime = 0;
		var speed = 40;
		var originals = list.querySelectorAll('.llb-services-carousel__item:not([aria-hidden="true"])');
		var setCount = originals.length;

		if (!setCount) {
			return;
		}

		function gapSize() {
			var styles = window.getComputedStyle(list);
			return parseFloat(styles.columnGap || styles.gap) || 0;
		}

		function setWidth() {
			var first = originals[0];
			if (!first) {
				return 0;
			}
			/* One full set including the gap after the last card (equals gap before the clone). */
			return first.getBoundingClientRect().width * setCount + gapSize() * setCount;
		}

		function applyTransform(animate) {
			if (animate) {
				list.style.transition = 'transform 0.45s ease';
			} else {
				list.style.transition = 'none';
			}
			list.style.transform = 'translateX(' + (-offset) + 'px)';
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
			if (changed && silent) {
				applyTransform(false);
			}
		}

		function stepBy(dir) {
			var first = originals[0];
			if (!first) {
				return;
			}
			var step = first.getBoundingClientRect().width + gapSize();
			stepping = true;
			paused = true;
			offset += dir * step;
			applyTransform(true);

			window.setTimeout(function () {
				normalize(true);
				stepping = false;
				if (!reduceMotion && !root.matches(':hover') && !root.contains(document.activeElement)) {
					paused = false;
				}
			}, 460);
		}

		function tick(now) {
			if (!lastTime) {
				lastTime = now;
			}
			var delta = (now - lastTime) / 1000;
			lastTime = now;

			if (!reduceMotion && !paused && !stepping) {
				offset += speed * delta;
				normalize(false);
				applyTransform(false);
			}

			window.requestAnimationFrame(tick);
		}

		root.classList.add('is-js-carousel');

		root.addEventListener('mouseenter', function () {
			paused = true;
		});
		root.addEventListener('mouseleave', function () {
			if (!stepping && !reduceMotion) {
				paused = false;
			}
		});
		root.addEventListener('focusin', function () {
			paused = true;
		});
		root.addEventListener('focusout', function () {
			if (!root.contains(document.activeElement) && !stepping && !reduceMotion) {
				paused = false;
			}
		});

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
			normalize(true);
		});

		applyTransform(false);
		window.requestAnimationFrame(tick);
	}

	document.querySelectorAll('[data-llb-services-carousel]').forEach(initServicesCarousel);
})();
