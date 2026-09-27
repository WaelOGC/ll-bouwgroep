/**
 * Main theme script.
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (!reduceMotion) {
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

	/* Home FAQ accordion (design v2) */
	document.querySelectorAll('.qa > button').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var q = btn.parentNode;
			var open = q.classList.toggle('open');
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	});

	/* Image reveal (.rv) */
	var rvs = document.querySelectorAll('.rv');
	if (!reduceMotion && 'IntersectionObserver' in window && rvs.length) {
		var rvObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('in');
						rvObserver.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.15 }
		);
		rvs.forEach(function (el) {
			rvObserver.observe(el);
		});
	} else {
		rvs.forEach(function (el) {
			el.classList.add('in');
		});
	}

	/* Legacy scroll reveal (inner pages) */
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

	/* Gallery slider (single project) */
	function initGallerySlider(rootEl) {
		if (rootEl.hasAttribute('data-llb-gallery-static')) {
			return;
		}

		var slides = rootEl.querySelectorAll('[data-llb-gallery-slide]');
		var thumbs = rootEl.querySelectorAll('[data-llb-gallery-thumb]');
		var prevBtn = rootEl.querySelector('[data-llb-gallery-prev]');
		var nextBtn = rootEl.querySelector('[data-llb-gallery-next]');
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
				thumb.classList.toggle('is-active', i === index);
				thumb.setAttribute('aria-current', i === index ? 'true' : 'false');
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
	}

	document.querySelectorAll('[data-llb-gallery-slider]').forEach(initGallerySlider);

	/* USP count-up on inner pages that still use the strip */
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
			var p = Math.min(1, (ts - start) / duration);
			el.textContent = String(Math.round(target * p));
			if (p < 1) {
				window.requestAnimationFrame(step);
			}
		}
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
					entry.target.querySelectorAll('[data-llb-count]').forEach(animateCount);
					countObserver.unobserve(entry.target);
				});
			},
			{ threshold: 0.35 }
		);
		document.querySelectorAll('.llb-home-usp, .llb-usp-strip').forEach(function (rootEl) {
			countObserver.observe(rootEl);
		});
	}
})();
