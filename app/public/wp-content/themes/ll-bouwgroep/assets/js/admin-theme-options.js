(function () {
	'use strict';

	var root = document.querySelector('.llbo');
	if (!root) {
		return;
	}

	var tabs = [].slice.call(root.querySelectorAll('.llbo-nav [role=tab]'));
	var form = document.getElementById('llbo-form');
	var bar = document.getElementById('savebar');
	var toast = document.getElementById('toast');
	var dirty = false;
	var ready = false;

	var tabOf = {
		animations: 'general',
		projects: 'general',
		back_to_top: 'general',
		whatsapp_enabled: 'contact',
		mobile_bar_enabled: 'contact',
		schema_local_business: 'seo',
		breadcrumbs: 'seo',
		maintenance_enabled: 'maint',
		announcement_enabled: 'ann'
	};

	var meta = {
		animations: ['Animations', 'Motion effects'],
		projects: ['Projects', 'Projecten page & sections'],
		back_to_top: ['Back to top', 'Scroll button'],
		whatsapp_enabled: ['WhatsApp button', 'Floating button'],
		mobile_bar_enabled: ['Mobile contact bar', 'Phones only'],
		schema_local_business: ['Local business data', 'Google local search'],
		breadcrumbs: ['Breadcrumbs', 'Above page titles'],
		maintenance_enabled: ['Maintenance mode', 'Holding page'],
		announcement_enabled: ['Announcement bar', 'Above the header']
	};

	function readTabFromUrl() {
		var params = new URLSearchParams(window.location.search);
		var q = params.get('tab');
		if (q) {
			return q;
		}
		var hash = (window.location.hash || '').replace(/^#/, '');
		if (hash.indexOf('tab=') === 0) {
			return hash.slice(4);
		}
		if (hash) {
			return hash;
		}
		return 'overview';
	}

	function setUrlTab(t) {
		var url = new URL(window.location.href);
		url.searchParams.set('tab', t);
		url.hash = t;
		history.replaceState(null, '', url.pathname + url.search + url.hash);
		if (form) {
			var ref = form.querySelector('input[name="_wp_http_referer"]');
			if (ref) {
				ref.value = url.pathname + url.search + url.hash;
			}
		}
	}

	function go(t) {
		if (!document.getElementById('p-' + t)) {
			t = 'overview';
		}
		tabs.forEach(function (b) {
			b.setAttribute('aria-selected', b.dataset.tab === t ? 'true' : 'false');
		});
		root.querySelectorAll('.llbo-panel').forEach(function (p) {
			p.classList.toggle('active', p.id === 'p-' + t);
		});
		setUrlTab(t);
		window.scrollTo({ top: 0 });
	}

	tabs.forEach(function (b) {
		b.addEventListener('click', function () {
			go(b.dataset.tab);
		});
	});

	var grid = document.getElementById('ov-grid');
	if (grid) {
		Object.keys(meta).forEach(function (k) {
			var main = document.querySelector('[data-key="' + k + '"]');
			if (!main) {
				return;
			}
			var card = main.closest('.card');
			var ic = card ? card.querySelector('.card-ic').innerHTML : '';
			var d = document.createElement('div');
			d.className = 'ov';
			d.innerHTML =
				'<div class="ov-top"><div class="card-ic">' +
				ic +
				'</div><label class="sw"><input type="checkbox" data-mirror="' +
				k +
				'" aria-label="' +
				meta[k][0] +
				'"' +
				(main.checked ? ' checked' : '') +
				'><span></span></label></div><div><h4>' +
				meta[k][0] +
				'</h4><p>' +
				meta[k][1] +
				'</p></div><a href="#" data-go="' +
				tabOf[k] +
				'">Settings →</a>';
			grid.appendChild(d);
		});

		grid.addEventListener('click', function (e) {
			var a = e.target.closest('[data-go]');
			if (a) {
				e.preventDefault();
				go(a.dataset.go);
			}
		});
	}

	function sync(k, v) {
		document.querySelectorAll('[data-key="' + k + '"],[data-mirror="' + k + '"]').forEach(function (i) {
			i.checked = v;
		});
		var main = document.querySelector('[data-key="' + k + '"]');
		if (!main) {
			return;
		}
		var card = main.closest('.card');
		if (!card) {
			return;
		}
		var b = card.querySelector('.card-b');
		if (b) {
			b.hidden = !v;
		}
		var bd = card.querySelector('.badge');
		if (bd) {
			bd.textContent = v ? 'On' : 'Off';
			bd.classList.toggle('off', !v);
		}
		refresh();
	}

	function socialFilled() {
		var n = 0;
		document.querySelectorAll('[data-soc]').forEach(function (i) {
			if (i.value.trim()) {
				n++;
			}
		});
		return n > 0;
	}

	function refresh() {
		var n = 0;
		Object.keys(meta).forEach(function (k) {
			var el = document.querySelector('[data-key="' + k + '"]');
			if (el && el.checked) {
				n++;
			}
		});
		var countEl = document.querySelector('[data-count-on]');
		if (countEl) {
			countEl.textContent = String(n);
		}

		var st = {
			general: ['animations', 'projects', 'back_to_top'],
			contact: ['whatsapp_enabled', 'mobile_bar_enabled'],
			seo: ['schema_local_business', 'breadcrumbs'],
			maint: ['maintenance_enabled'],
			ann: ['announcement_enabled']
		};
		Object.keys(st).forEach(function (t) {
			var on = st[t].some(function (k) {
				var el = document.querySelector('[data-key="' + k + '"]');
				return el && el.checked;
			});
			var d = document.querySelector('.dot[data-for="' + t + '"]');
			if (d) {
				d.classList.toggle('on', on);
			}
		});

		var socialDot = document.querySelector('.dot[data-for="social"]');
		if (socialDot) {
			socialDot.classList.toggle('on', socialFilled());
		}

		var live = document.querySelector('.ov-stat .stat:nth-child(2)');
		var mEl = document.querySelector('[data-key="maintenance_enabled"]');
		if (live && mEl) {
			var m = mEl.checked;
			live.classList.toggle('warn', m);
			live.querySelector('b').textContent = m ? 'Maintenance' : 'Live';
			live.querySelector('span').textContent = m
				? 'visitors see the holding page'
				: 'website visible to visitors';
		}
	}

	function mark() {
		if (!ready) {
			return;
		}
		if (!dirty) {
			dirty = true;
			if (bar) {
				bar.classList.add('show');
			}
		}
	}

	document.addEventListener('change', function (e) {
		var t = e.target;
		var k = t.dataset.key || t.dataset.mirror;
		if (k) {
			sync(k, t.checked);
		}
		if ((form && form.contains(t)) || t.dataset.mirror) {
			mark();
		}
	});

	document.addEventListener('input', function (e) {
		if (form && form.contains(e.target)) {
			mark();
		}
		if (e.target.dataset.soc !== undefined) {
			prev();
			refresh();
		}
	});

	if (bar) {
		var saveBtn = document.getElementById('save');
		var discardBtn = document.getElementById('discard');
		if (saveBtn && form) {
			saveBtn.addEventListener('click', function () {
				dirty = false;
				form.submit();
			});
		}
		if (discardBtn) {
			discardBtn.addEventListener('click', function () {
				dirty = false;
				window.location.reload();
			});
		}
	}

	window.addEventListener('beforeunload', function (e) {
		if (!dirty) {
			return;
		}
		e.preventDefault();
		e.returnValue = '';
	});

	document.querySelectorAll('[data-copy]').forEach(function (b) {
		b.addEventListener('click', function () {
			var code = b.parentElement ? b.parentElement.querySelector('code') : null;
			var text = code ? code.textContent : '';
			if (text && navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(text).then(function () {
					b.textContent = 'Copied';
					setTimeout(function () {
						b.textContent = 'Copy';
					}, 1500);
				});
			} else {
				b.textContent = 'Copied';
				setTimeout(function () {
					b.textContent = 'Copy';
				}, 1500);
			}
		});
	});

	var icons = {};
	document.querySelectorAll('.soc').forEach(function (s) {
		var input = s.querySelector('input');
		var si = s.querySelector('.si');
		if (input && si) {
			icons[input.dataset.soc] = si.innerHTML;
		}
	});

	function prev() {
		var p = document.getElementById('soc-prev');
		if (!p) {
			return;
		}
		var h = '';
		document.querySelectorAll('[data-soc]').forEach(function (i) {
			if (i.value.trim()) {
				h +=
					'<a href="#" aria-label="' +
					i.getAttribute('aria-label') +
					'">' +
					icons[i.dataset.soc] +
					'</a>';
			}
		});
		p.innerHTML = h + '<em>' + (h ? '' : 'No profiles filled in') + '</em>';
	}

	prev();
	Object.keys(meta).forEach(function (k) {
		var el = document.querySelector('[data-key="' + k + '"]');
		if (el) {
			sync(k, el.checked);
		}
	});
	refresh();
	go(readTabFromUrl());
	ready = true;

	if (toast && root.getAttribute('data-saved') === '1') {
		toast.classList.add('show');
		setTimeout(function () {
			toast.classList.remove('show');
		}, 1800);
		var url = new URL(window.location.href);
		url.searchParams.delete('settings-updated');
		history.replaceState(null, '', url.pathname + url.search + url.hash);
	}
})();
