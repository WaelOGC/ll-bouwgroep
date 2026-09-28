/**
 * Main theme script.
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

	document.documentElement.classList.add('llb-js');

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

	if (!reduceMotion && 'IntersectionObserver' in window && rvs.length) {
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
})();
