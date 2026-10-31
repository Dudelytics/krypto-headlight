/* Headlight: explicit opt-in per page; no visitor IDs or browser storage. */
(() => {
  'use strict';
  const config = document.getElementById('headlight-analytics');
  const start = document.getElementById('analytics-start');
  const stop = document.getElementById('analytics-stop');
  const status = document.getElementById('analytics-status');
  if (!config || !start || !stop || !status || location.hostname !== 'headlight.dudelytics.com') return;
  const id = config.dataset.websiteId;
  if (!/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(id || '')) return;
  let scriptUrl;
  try { scriptUrl = new URL(config.dataset.scriptUrl); } catch { return; }
  if (scriptUrl.protocol !== 'https:' || !['cloud.umami.is', 'analytics.eu.umami.is', 'analytics.us.umami.is'].includes(scriptUrl.hostname) || scriptUrl.pathname !== '/script.js') return;
  const privacySignal = navigator.globalPrivacyControl || navigator.doNotTrack === '1';
  if (privacySignal) { start.disabled = true; status.textContent = 'Dein Datenschutzsignal wird respektiert: Messung ausgeschaltet.'; return; }
  let enabled = false, ready = false, loading = false, pageSent = false;
  let active = 0, last = performance.now(), interaction = last;
  const sent = new Set();
  const article = document.querySelector('article .prose');
  const isIssue = /^\/ausgaben\/\d{4}-\d{2}-\d{2}\/$/.test(location.pathname);
  const path = isIssue ? location.pathname : ['/','/archiv/','/ueber/'].includes(location.pathname) ? location.pathname : '/other/';
  let referrer = '';
  try { referrer = new URL(document.referrer).origin; } catch { /* Direct or unavailable. */ }
  function track(name) {
    if (!enabled || !ready || typeof window.umami?.track !== 'function') return;
    // Explicit payload: never forward query strings, fragments, link URLs or user input.
    const payload = { website: id, hostname: location.hostname, url: path, referrer };
    if (name) payload.name = name;
    try { Promise.resolve(window.umami.track(payload)).catch(() => {}); } catch { /* Analytics must not interrupt reading. */ }
  }
  function once(name) { if (enabled && ready && !sent.has(name)) { sent.add(name); track(name); } }
  function loaded() {
    loading = false;
    ready = typeof window.umami?.track === 'function';
    if (!ready) { failed(); return; }
    start.disabled = false;
    if (!enabled) return;
    status.textContent = 'Messung für diesen Seitenaufruf eingeschaltet.';
    if (!pageSent) { pageSent = true; track(); }
    last = interaction = performance.now();
  }
  function failed() {
    enabled = false; loading = false; start.disabled = false; stop.hidden = true;
    status.textContent = 'Messung nicht verfügbar. Du kannst den Bericht weiter lesen.';
  }
  start.addEventListener('click', () => {
    if (enabled || loading) return;
    enabled = true; stop.hidden = false; last = interaction = performance.now();
    if (ready) { loaded(); return; }
    loading = true; start.disabled = true;
    const script = document.createElement('script');
    script.src = scriptUrl.href; script.defer = true; script.referrerPolicy = 'no-referrer';
    script.dataset.websiteId = id; script.dataset.autoTrack = 'false';
    script.dataset.domains = 'headlight.dudelytics.com';
    script.onload = loaded; script.onerror = failed;
    document.head.appendChild(script);
  });
  stop.addEventListener('click', () => {
    enabled = false; stop.hidden = true; status.textContent = 'Messung ausgeschaltet.';
  });
  for (const type of ['pointerdown','keydown','scroll']) window.addEventListener(type, () => { interaction = performance.now(); }, { passive: true });
  setInterval(() => {
    const now = performance.now(), elapsed = Math.max(0, Math.min(now - last, 1000)); last = now;
    if (!enabled || !ready || !isIssue || document.hidden || !document.hasFocus() || now - interaction > 60000) return;
    active += elapsed;
    for (const seconds of [30,120,300]) if (active >= seconds * 1000) once('active_' + seconds + 's');
    if (article) {
      const rect = article.getBoundingClientRect();
      const depth = Math.max(0, Math.min(100, 100 * (innerHeight - rect.top) / Math.max(rect.height, 1)));
      for (const threshold of [25,50,75,90]) if (depth >= threshold) once('article_depth_' + threshold);
    }
  }, 1000);
  document.addEventListener('click', e => {
    const link = e.target.closest?.('a[href]');
    if (!link || !isIssue) return;
    let url; try { url = new URL(link.href); } catch { return; }
    if (url.hostname === 'github.com' && url.pathname.startsWith('/Dudelytics/krypto-headlight/discussions')) once('discussion_click');
    else if (article?.contains(link) && ['http:','https:'].includes(url.protocol) && url.hostname !== location.hostname) once('source_click');
  });
})();
