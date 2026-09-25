// ---------- Theme toggle ----------
const root = document.documentElement;
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
const currentTheme = () => root.dataset.theme || (prefersDark.matches ? 'dark' : 'light');

document.getElementById('theme-toggle').addEventListener('click', () => {
  const next = currentTheme() === 'dark' ? 'light' : 'dark';
  root.dataset.theme = next;
  try { localStorage.setItem('zt-theme', next); } catch (e) {}
});

// ---------- Mobile menu ----------
const nav = document.getElementById('nav');
const menuBtn = document.getElementById('menu-toggle');

const setMenu = (open) => {
  nav.classList.toggle('open', open);
  menuBtn.setAttribute('aria-expanded', String(open));
  menuBtn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
};
menuBtn.addEventListener('click', () => setMenu(!nav.classList.contains('open')));
nav.addEventListener('click', (e) => { if (e.target.closest('a')) setMenu(false); });
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });

// ---------- Pricing tabs ----------
const tabs = [...document.querySelectorAll('[role="tab"]')];

const selectTab = (tab) => {
  tabs.forEach((t) => {
    const selected = t === tab;
    t.setAttribute('aria-selected', String(selected));
    t.tabIndex = selected ? 0 : -1;
    document.getElementById(t.getAttribute('aria-controls')).hidden = !selected;
  });
  replayReveal(document.getElementById(tab.getAttribute('aria-controls')).querySelectorAll('.price'));
};
tabs.forEach((tab, i) => {
  tab.addEventListener('click', () => selectTab(tab));
  tab.addEventListener('keydown', (e) => {
    if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
    const next = tabs[(i + (e.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length];
    selectTab(next);
    next.focus();
  });
});

// ---------- Contact form (homepage only) ----------
const form = document.getElementById('contact-form');

if (form) {
  initContactForm(form);
}

function initContactForm(form) {
  // CTA buttons that preselect a topic
  document.querySelectorAll('[data-topic]').forEach((el) => {
    el.addEventListener('click', () => { form.elements.topic.value = el.dataset.topic; });
  });

  // Check required fields before the form posts to WordPress
  const note = document.getElementById('form-note');
  const btn = form.querySelector('[type="submit"]');
  const btnLabel = btn.textContent;

  // Re-enable the button when the visitor comes back with the browser's Back button
  window.addEventListener('pageshow', () => { btn.disabled = false; btn.textContent = btnLabel; });

  form.addEventListener('submit', (e) => {
    const f = form.elements;
    let firstInvalid = null;

    [f.name, f.email, f.goal].forEach((field) => {
      const ok = field.value.trim() !== '' && field.checkValidity();
      field.setAttribute('aria-invalid', String(!ok));
      if (!ok && !firstInvalid) firstInvalid = field;
    });

    if (firstInvalid) {
      e.preventDefault();
      note.textContent = 'Please fill in your name, a valid email and your goal.';
      note.className = 'form-note small error';
      firstInvalid.focus();
      return;
    }

    btn.disabled = true;
    btn.textContent = 'Sending…';
  });
}

// ---------- Motion ----------
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

// Header shadow once the page is scrolled
const header = document.querySelector('.site-header');
const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 8);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

// Fade elements in as they scroll into view, staggered within each group.
// Only elements below the fold are hidden, so nothing visible flashes on load.
const REVEAL = [
  '.section-head', '.table-wrap', '.callout', '.service', '.audiences h3', '.chips li',
  '.tabs', '.price', '.terms h3', '.terms-list li', '.steps li', '.cycle li',
  '.quality-grid .card', '.agencies-inner > div > *', '.faq details',
  '.contact-inner > div', '.contact-inner .form', '.entry',
].join(',');

function finishReveal(el) {
  el.addEventListener('transitionend', function done(e) {
    if (e.target !== el || e.propertyName !== 'transform') return;
    el.classList.remove('reveal', 'is-visible');
    el.style.removeProperty('--delay');
    el.removeEventListener('transitionend', done);
  });
}

function stagger(el) {
  const siblings = [...el.parentElement.children].filter((c) => c.classList.contains('reveal'));
  el.style.setProperty('--delay', `${Math.min(siblings.indexOf(el), 6) * 70}ms`);
}

// Replay the reveal on a group that was already shown (used by the pricing tabs)
function replayReveal(els) {
  if (reduceMotion.matches) return;
  els.forEach((el) => { el.classList.remove('is-visible'); el.classList.add('reveal'); });
  els.forEach(stagger);
  void document.body.offsetWidth;
  els.forEach((el) => { finishReveal(el); el.classList.add('is-visible'); });
}

if (!reduceMotion.matches && 'IntersectionObserver' in window) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      finishReveal(entry.target);
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.1 });

  const items = [...document.querySelectorAll(REVEAL)]
    .filter((el) => el.getBoundingClientRect().top > window.innerHeight);
  items.forEach((el) => el.classList.add('reveal'));
  items.forEach((el) => { stagger(el); observer.observe(el); });
}
