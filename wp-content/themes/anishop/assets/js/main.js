/* Anishop — main.js */
(function () {
	'use strict';

	var d = document;

	function on(el, ev, fn) { el && el.addEventListener(ev, fn); }
	function all(sel, ctx) { return Array.prototype.slice.call((ctx || d).querySelectorAll(sel)); }

	/* ---------- Mobile drawer ---------- */
	var drawer = d.getElementById('mobile-drawer');

	function openDrawer() {
		if (!drawer) { return; }
		drawer.hidden = false;
		d.body.style.overflow = 'hidden';
		var t = drawer.querySelector('[data-drawer-close].icon-btn');
		t && t.focus();
	}

	function closeDrawer() {
		if (!drawer || drawer.hidden) { return; }
		drawer.hidden = true;
		d.body.style.overflow = '';
	}

	all('[data-drawer-toggle]').forEach(function (btn) {
		on(btn, 'click', openDrawer);
	});

	all('#mobile-drawer [data-drawer-close]').forEach(function (el) {
		on(el, 'click', closeDrawer);
	});

	on(d, 'keydown', function (e) {
		if (e.key === 'Escape') { closeDrawer(); closeCartDrawer(); }
	});

	/* ---------- Cart drawer (mini-cart) ---------- */
	var cartDrawer = d.getElementById('cart-drawer');

	function openCartDrawer() {
		if (!cartDrawer) { return; }
		cartDrawer.hidden = false;
		d.body.style.overflow = 'hidden';
		d.querySelectorAll('[data-cart-drawer-toggle]').forEach(function (b) {
			b.setAttribute('aria-expanded', 'true');
		});
		var t = cartDrawer.querySelector('[data-cart-drawer-close].icon-btn');
		t && t.focus();
	}

	function closeCartDrawer() {
		if (!cartDrawer || cartDrawer.hidden) { return; }
		cartDrawer.hidden = true;
		d.body.style.overflow = '';
		d.querySelectorAll('[data-cart-drawer-toggle]').forEach(function (b) {
			b.setAttribute('aria-expanded', 'false');
		});
	}

	all('[data-cart-drawer-toggle]').forEach(function (btn) {
		on(btn, 'click', function (e) {
			e.preventDefault();
			openCartDrawer();
		});
	});

	all('#cart-drawer [data-cart-drawer-close]').forEach(function (el) {
		on(el, 'click', closeCartDrawer);
	});

	/* ---------- Hero slider (auto-advance + arrows) ---------- */
	var heroStates = all('#hero-slide-1, #hero-slide-2, #hero-slide-3');
	var heroSlides = all('.hero-slide');

	if (heroStates.length === 3 && heroSlides.length === 3) {
		var current = 0;
		var timer = null;

		function goTo(i) {
			current = (i + 3) % 3;
			heroStates[current].checked = true;
			heroSlides.forEach(function (slide, idx) {
				slide.classList.toggle('is-active', idx === current);
			});
		}

		function startAuto() {
			stopAuto();
			timer = setInterval(function () { goTo(current + 1); }, 6000);
		}

		function stopAuto() {
			if (timer) { clearInterval(timer); timer = null; }
		}

		var prevBtn = d.querySelector('[data-slider-prev]');
		var nextBtn = d.querySelector('[data-slider-next]');
		on(prevBtn, 'click', function () { goTo(current - 1); startAuto(); });
		on(nextBtn, 'click', function () { goTo(current + 1); startAuto(); });

		all('.hero-dot').forEach(function (dot, idx) {
			on(dot, 'click', function () { goTo(idx); startAuto(); });
		});

		var slider = d.querySelector('[data-slider]');
		if (slider) {
			slider.addEventListener('mouseenter', stopAuto);
			slider.addEventListener('mouseleave', startAuto);
		}

		/* Touch swipe */
		var startX = null;
		slider && slider.addEventListener('touchstart', function (e) {
			startX = e.touches[0].clientX;
		}, { passive: true });
		slider && slider.addEventListener('touchend', function (e) {
			if (startX === null) { return; }
			var dx = e.changedTouches[0].clientX - startX;
			if (Math.abs(dx) > 44) { goTo(dx > 0 ? current + 1 : current - 1); startAuto(); }
			startX = null;
		}, { passive: true });

		startAuto();
	}

	/* ---------- Countdown ---------- */
	all('[data-countdown]').forEach(function (el) {
		var end = parseInt(el.getAttribute('data-countdown-end') || '0', 10);
		if (!end) { return; }
		var h = el.querySelector('[data-cd="hours"]');
		var m = el.querySelector('[data-cd="minutes"]');
		var s = el.querySelector('[data-cd="seconds"]');

		function pad(n) { return (n < 10 ? '0' : '') + n; }
		function fa(str) {
			return String(str).replace(/[0-9]/g, function (ch) {
				return '۰۱۲۳۴۵۶۷۸۹'['0123456789'.indexOf(ch)];
			});
		}

		function tick() {
			var diff = Math.max(0, end - Math.floor(Date.now() / 1000));
			var hours = Math.floor(diff / 3600);
			var mins = Math.floor((diff % 3600) / 60);
			var secs = diff % 60;
			h && (h.textContent = fa(pad(hours)));
			m && (m.textContent = fa(pad(mins)));
			s && (s.textContent = fa(pad(secs)));
			if (!diff) { clearInterval(iv); }
		}

		tick();
		var iv = setInterval(tick, 1000);
	});

	/* ---------- Horizontal carousels (arrow scrolling) ---------- */
	all('[data-carousel]').forEach(function (car) {
		var track = car.querySelector('[data-carousel-track]');
		if (!track) { return; }

		function step() {
			var item = track.firstElementChild;
			return item ? item.getBoundingClientRect().width + 14 : 260;
		}

		function go(dir) {
			var rtl = (d.documentElement.dir || '').toLowerCase() === 'rtl';
			track.scrollBy({ left: dir * step() * (rtl ? -1 : 1), behavior: 'smooth' });
		}

		all('[data-carousel-prev]', car).forEach(function (b) { on(b, 'click', function () { go(-1); }); });
		all('[data-carousel-next]', car).forEach(function (b) { on(b, 'click', function () { go(1); }); });
	});

	/* ---------- Quantity steppers ---------- */
	d.addEventListener('click', function (e) {
		var plus = e.target.closest('.qty-plus');
		var minus = e.target.closest('.qty-minus');
		if (!plus && !minus) { return; }

		var wrap = (plus || minus).closest('.quantity');
		var input = wrap && wrap.querySelector('input.qty');
		if (!input) { return; }

		var val = parseInt(input.value, 10) || 0;
		var min = input.min !== '' && !isNaN(parseInt(input.min, 10)) ? parseInt(input.min, 10) : 1;
		var max = input.max !== '' && !isNaN(parseInt(input.max, 10)) ? parseInt(input.max, 10) : Infinity;
		var next = plus ? val + 1 : val - 1;

		input.value = Math.min(max, Math.max(min, next));
		input.dispatchEvent(new Event('change', { bubbles: true }));
	});

	/* ---------- AJAX cart: keep header count + mini-cart drawer in sync ---------- */
	var countEls = all('[data-cart-count]');

	function fragmentsFromEvent(e) {
		var det = e.detail;
		if (!det) { return null; }
		if (Array.isArray(det)) { return det[0] || null; } // jQuery event: detail is the args array.
		return det.fragments || null;
	}

	function syncMiniCart(html) {
		var tmp = d.createElement('div');
		tmp.innerHTML = html;
		var fresh = tmp.querySelector('[data-mini-cart-body]');
		var current = d.querySelector('[data-mini-cart-body]');
		if (fresh && current) { current.innerHTML = fresh.innerHTML; }
	}

	function handleCartFragments(fragments) {
		if (!fragments) { return; }

		Object.keys(fragments).forEach(function (key) {
			var html = fragments[key];
			if (typeof html !== 'string') { return; }

			if (html.indexOf('data-mini-cart-body') !== -1) { syncMiniCart(html); }

			var tmp = d.createElement('div');
			tmp.innerHTML = html;
			var count = tmp.querySelector('[data-cart-count]');
			if (count) {
				countEls.forEach(function (target) { target.textContent = count.textContent; });
			}
		});
	}

	['added_to_cart', 'removed_from_cart', 'wc_fragments_refreshed'].forEach(function (evt) {
		d.body.addEventListener(evt, function (e) {
			handleCartFragments(fragmentsFromEvent(e));
		});
	});

	/* ---------- Cart page: auto-refresh after qty change ---------- */
	/*
	 * WooCommerce replaces the whole cart form over AJAX after every update,
	 * so a listener bound to the original <form> dies after the first refresh
	 * (steppers only worked once). Listen at the document level instead —
	 * that survives the form swap. We deliberately do NOT stop propagation:
	 * core's own delegated handler re-enables the (disabled) update button
	 * on this same native `change` event.
	 */
	var debounce = null;
	var lastQtyInput = null;

	d.addEventListener('change', function (e) {
		if (!e.target || !e.target.classList || !e.target.classList.contains('qty')) { return; }
		if (e.target.closest('form.woocommerce-cart-form')) {
			lastQtyInput = e.target;
		}
	});

	d.addEventListener('change', function (e) {
		if (!e.target || !e.target.classList || !e.target.classList.contains('qty')) { return; }
		var form = e.target.closest('form.woocommerce-cart-form');
		if (!form) { return; }
		clearTimeout(debounce);
		debounce = setTimeout(function () {
			var btn = form.querySelector('[name="update_cart"]');
			if (btn && !btn.disabled) { btn.click(); }
		}, 600);
	});

	/* Keep keyboard/stepper focus on the quantity input across AJAX refreshes. */
	d.body.addEventListener('updated_wc_div', function () {
		var input = null;
		if (lastQtyInput && lastQtyInput.name) {
			input = d.querySelector('.woocommerce-cart-form input.qty[name="' + lastQtyInput.name + '"]');
		}
		if (!input) {
			input = d.querySelector('.woocommerce-cart-form input.qty');
		}
		if (input) { input.focus(); }
		lastQtyInput = null;
	});
})();
