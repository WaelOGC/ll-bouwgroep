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
	function mark(id) {
		links.forEach(function (a) { a.setAttribute('aria-current', a.getAttribute('href') === '#' + id ? 'true' : 'false'); });
	}
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) { if (e.isIntersecting) { mark(e.target.id); } });
		}, { rootMargin: '-20% 0px -70% 0px' });
		root.querySelectorAll('.llbh-art').forEach(function (a) { io.observe(a); });
	}
})();
