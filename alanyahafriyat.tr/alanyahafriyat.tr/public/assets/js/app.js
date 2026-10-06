(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  // Sticky header shadow
  var header = $('#site-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 20); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Mobile nav (offcanvas): açıkken body scroll kilitlenir, alt bar gizlenir
  var nav = $('#main-nav');
  var overlay = $('.nav__overlay');
  function openNav() {
    if (!nav) return;
    nav.classList.add('is-open');
    overlay && overlay.classList.add('is-open');
    document.body.classList.add('nav-locked');
  }
  function closeNav() {
    if (!nav) return;
    nav.classList.remove('is-open');
    overlay && overlay.classList.remove('is-open');
    document.body.classList.remove('nav-locked');
  }
  $$('[data-nav-toggle]').forEach(function (b) { b.addEventListener('click', openNav); });
  $$('[data-nav-close]').forEach(function (b) { b.addEventListener('click', closeNav); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeNav(); });

  // Menü içi accordion (Hizmetler alt menüsü)
  $$('[data-sub-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var group = btn.closest('.nav__group');
      if (group) group.classList.toggle('is-open');
    });
  });

  // FAQ accordion
  $$('.faq__q').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.faq__item');
      var ans = $('.faq__a', item);
      var open = item.classList.toggle('is-open');
      ans.style.maxHeight = open ? ans.scrollHeight + 'px' : null;
    });
  });

  // WhatsApp / phone click events -> backend
  function track(type, meta) {
    try {
      var body = new URLSearchParams();
      body.append('event_type', type);
      body.append('page_url', location.pathname);
      if (meta) body.append('meta', meta);
      fetch(baseUrl('event'), { method: 'POST', headers: { 'X-CSRF-Token': window.__CSRF || '' }, body: body });
    } catch (e) {}
  }
  function baseUrl(p) { return (location.origin + '/' + p); }
  $$('[data-wa-event]').forEach(function (a) {
    a.addEventListener('click', function () { track('whatsapp_click'); });
  });

  // Popup
  var popup = $('#site-popup');
  if (popup) {
    var id = popup.getAttribute('data-id');
    var repeat = parseInt(popup.getAttribute('data-repeat') || '24', 10);
    var delay = parseInt(popup.getAttribute('data-delay') || '3', 10);
    var mobileOk = popup.getAttribute('data-mobile') === '1';
    var key = 'eh_popup_' + id;
    var last = parseInt(localStorage.getItem(key) || '0', 10);
    var isMobile = window.innerWidth < 768;
    var expired = (Date.now() - last) > repeat * 3600 * 1000;
    if (expired && (mobileOk || !isMobile)) {
      setTimeout(function () { popup.classList.add('is-open'); }, delay * 1000);
    }
    function closePopup() { popup.classList.remove('is-open'); localStorage.setItem(key, String(Date.now())); }
    $$('[data-popup-close]', popup).forEach(function (b) { b.addEventListener('click', closePopup); });
    var pbtn = $('[data-popup-btn]', popup);
    if (pbtn) pbtn.addEventListener('click', function () { track('popup_click', 'popup:' + id); localStorage.setItem(key, String(Date.now())); });
  }

  // Simple lightbox
  var lb;
  $$('[data-lightbox]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var href = a.getAttribute('href');
      if (!href || href === '#') return;
      e.preventDefault();
      if (!lb) {
        lb = document.createElement('div');
        lb.className = 'lightbox';
        lb.style.cssText = 'position:fixed;inset:0;z-index:200;background:rgba(0,0,0,.9);display:flex;align-items:center;justify-content:center;padding:24px;cursor:zoom-out';
        lb.innerHTML = '<img style="max-width:92%;max-height:92%;border-radius:10px">';
        lb.addEventListener('click', function () { lb.style.display = 'none'; });
        document.body.appendChild(lb);
      }
      $('img', lb).src = href;
      lb.style.display = 'flex';
    });
  });

  // Global scroll reveal / stagger animasyonları
  // CSS tek başına içeriği gizlemez; yalnızca JS aktifse motion-ready eklenir.
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!reduceMotion && 'IntersectionObserver' in window) {
    var motionSelectors = [
      '.hero__eyebrow', '.hero h1', '.hero__sub', '.hero__cta', '.quickform',
      '.badge', '.sec-head', '.scard', '.ecard', '.pstep', '.gitem',
      '.region-chip', '.bcard', '.faq__item', '.why-card', '.contact-row',
      '.machine-anim__text', '.machine-scene', '.page-hero .container',
      '.prose > h2', '.prose > h3', '.final-cta__inner'
    ].join(',');

    var motionItems = $(motionSelectors);
    motionItems.forEach(function (el, i) {
      el.classList.add('motion-ready');
      // Aynı grid/listede peş peşe gelen öğelere küçük stagger ver.
      var parent = el.parentElement;
      if (parent) {
        var siblings = Array.prototype.filter.call(parent.children, function (child) {
          return child.matches && child.matches(motionSelectors);
        });
        var index = siblings.indexOf(el);
        if (index > -1) el.style.setProperty('--motion-delay', Math.min(index * 55, 220) + 'ms');
      }
    });

    var motionObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    motionItems.forEach(function (el) { motionObserver.observe(el); });
  }

  // AJAX lead form
  $$('[data-ajax-lead]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var msg = $('[data-form-msg]', form);
      var btn = $('button[type=submit]', form);
      var orig = btn.innerHTML;
      btn.disabled = true; btn.innerHTML = 'Gönderiliyor...';
      fetch(form.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(form) })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          btn.disabled = false; btn.innerHTML = orig;
          if (msg) {
            msg.textContent = res.message || '';
            msg.className = 'form-msg ' + (res.ok ? 'form-msg--ok' : 'form-msg--err');
            msg.style.cssText = 'padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:10px;' + (res.ok ? 'background:#e7f7ed;color:#1a7f45' : 'background:#fdecec;color:#b23b3b');
          }
          if (res.ok) form.reset();
        })
        .catch(function () { btn.disabled = false; btn.innerHTML = orig; });
    });
  });
})();
