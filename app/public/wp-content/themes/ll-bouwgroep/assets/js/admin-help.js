(function () {
	var root = document.getElementById('llbh');
	if (!root) { return; }
	root.classList.add('is-js');

	/* Language EN / NL (remembered) */
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

	/* Views: one group at a time */
	var links = [].slice.call(root.querySelectorAll('.llbh-nav a[href^="#h-"]'));
	var groups = [].slice.call(root.querySelectorAll('.llbh-grp'));
	var items = [].slice.call(root.querySelectorAll('.llbh-nav [data-view]'));
	var content = root.querySelector('.llbh-content');
	function setView(v, toTop) {
		root.setAttribute('data-view', v);
		items.forEach(function (li) {
			var on = li.getAttribute('data-view') === v;
			li.classList.toggle('is-current', on);
			if (on && window.matchMedia('(max-width: 959px)').matches) {
				var ul = li.parentNode;
				var l = li.offsetLeft - ul.offsetLeft;
				if (l < ul.scrollLeft || l + li.offsetWidth > ul.scrollLeft + ul.clientWidth) { ul.scrollLeft = l - 8; }
			}
		});
		groups.forEach(function (btn) {
			btn.setAttribute('aria-expanded', btn.parentNode.getAttribute('data-view') === v ? 'true' : 'false');
		});
		if (toTop && content) {
			var y = content.getBoundingClientRect().top + window.pageYOffset - 70;
			if (window.pageYOffset > y) { window.scrollTo(0, Math.max(0, y)); }
		}
	}
	function viewOf(el) {
		var s = el && el.closest('.llbh-view');
		return s ? s.getAttribute('data-view') : 'start';
	}
	groups.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var v = btn.parentNode.getAttribute('data-view');
			if (root.getAttribute('data-view') !== v) {
				setView(v, true);
				try { history.replaceState(null, '', '#v-' + v); } catch (e) {}
			} else {
				btn.setAttribute('aria-expanded', btn.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');
			}
		});
	});
	links.forEach(function (a) {
		a.addEventListener('click', function () {
			var v = viewOf(document.getElementById(a.getAttribute('href').slice(1)));
			if (root.getAttribute('data-view') !== v) { setView(v, false); }
		});
	});
	root.querySelectorAll('[data-go]').forEach(function (b) {
		b.addEventListener('click', function () {
			var v = b.getAttribute('data-go');
			setView(v, true);
			try { history.replaceState(null, '', '#v-' + v); } catch (e) {}
		});
	});
	function fromHash(first) {
		var hash = (location.hash || '').slice(1);
		var target = hash ? document.getElementById(hash) : null;
		if (target && target.classList.contains('llbh-view')) {
			setView(target.getAttribute('data-view'), false);
		} else if (target && target.closest('.llbh-view')) {
			setView(viewOf(target), false);
			setTimeout(function () { target.scrollIntoView(); }, 0);
		} else if (first) {
			setView('start', false);
		}
	}
	fromHash(true);
	window.addEventListener('hashchange', function () { fromHash(false); });

	/* Active item in the side menu */
	function mark(id) {
		links.forEach(function (a) { a.setAttribute('aria-current', a.getAttribute('href') === '#' + id ? 'true' : 'false'); });
	}
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) { if (e.isIntersecting) { mark(e.target.id); } });
		}, { rootMargin: '-20% 0px -70% 0px' });
		root.querySelectorAll('.llbh-art').forEach(function (a) { io.observe(a); });
	}

	/* Screenshot frames + lightbox */
	function checkCut(frame) {
		var img = frame.querySelector('img');
		frame.classList.toggle('is-cut', !!img && img.offsetHeight > frame.clientHeight + 2);
	}
	var frames = [].slice.call(root.querySelectorAll('.llbh-shot-frame'));
	frames.forEach(function (f) {
		var img = f.querySelector('img');
		if (img) { img.addEventListener('load', function () { checkCut(f); }); }
		checkCut(f);
	});
	window.addEventListener('resize', function () { frames.forEach(checkCut); });
	root.addEventListener('click', function () { setTimeout(function () { frames.forEach(checkCut); }, 0); });
	var lb = document.getElementById('llbh-lb');
	if (lb && typeof lb.showModal === 'function') {
		var lbImg = lb.querySelector('img');
		frames.forEach(function (f) {
			f.addEventListener('click', function () {
				lbImg.src = f.getAttribute('data-full');
				lb.showModal();
			});
		});
		lb.querySelector('.llbh-lb-x').addEventListener('click', function () { lb.close(); });
		lb.addEventListener('click', function (e) { if (e.target === lb) { lb.close(); } });
	} else {
		frames.forEach(function (f) {
			f.addEventListener('click', function () { window.open(f.getAttribute('data-full'), '_blank'); });
		});
	}
})();
