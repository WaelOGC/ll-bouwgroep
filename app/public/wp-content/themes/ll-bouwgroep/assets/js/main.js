/**
 * Main theme script.
 *
 * @package LL_Bouwgroep
 */

(function () {
	'use strict';

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
})();
