(function () {
	var root = document.getElementById('llbh');
	if (!root) { return; }
	var KEY = 'llbHelpLang';
	function setLang(l) {
		root.setAttribute('data-show', l);
		root.querySelectorAll('[data-set-lang]').forEach(function (b) {
			b.setAttribute('aria-pressed', b.getAttribute('data-set-lang') === l ? 'true' : 'false');
		});
		try { localStorage.setItem(KEY, l); } catch (e) {}
	}
	var saved = null;
	try { saved = localStorage.getItem(KEY); } catch (e) {}
	if (saved === 'en' || saved === 'nl') { setLang(saved); }
	root.querySelectorAll('[data-set-lang]').forEach(function (b) {
		b.addEventListener('click', function () { setLang(b.getAttribute('data-set-lang')); });
	});
	/* Active section in the side menu */
	var links = [].slice.call(root.querySelectorAll('.llbh-nav a[href^="#h-"]'));
	/* Collapsible groups (+ / −) */
	var groups = [].slice.call(root.querySelectorAll('.llbh-grp'));
	function setGroup(btn, open) { btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
	groups.forEach(function (btn) {
		btn.addEventListener('click', function () {
			setGroup(btn, btn.getAttribute('aria-expanded') !== 'true');
		});
	});
	function openGroupOf(link) {
		var item = link.closest('.llbh-grp-item');
		groups.forEach(function (btn) { setGroup(btn, !!item && btn.parentNode === item); });
	}
	function mark(id) {
		links.forEach(function (a) {
			var on = a.getAttribute('href') === '#' + id;
			a.setAttribute('aria-current', on ? 'true' : 'false');
			if (on && a.closest('.llbh-grp-item')) {
				var btn = a.closest('.llbh-grp-item').querySelector('.llbh-grp');
				if (btn.getAttribute('aria-expanded') !== 'true') { openGroupOf(a); }
			}
		});
	}
	if (location.hash) {
		var start = root.querySelector('.llbh-nav a[href="' + location.hash + '"]');
		if (start && start.closest('.llbh-grp-item')) { openGroupOf(start); }
	}
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) { if (e.isIntersecting) { mark(e.target.id); } });
		}, { rootMargin: '-20% 0px -70% 0px' });
		root.querySelectorAll('.llbh-art').forEach(function (a) { io.observe(a); });
	}
})();
