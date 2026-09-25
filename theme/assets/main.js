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
  '.section-head', '.table-wrap', '.callout', '.service', '.audiences h3', '.chips li', '.stack h3', '.stack-grid > div',
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

// ---------- Spotlight border on cards (fine pointers) ----------
if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
  document.querySelectorAll('.card, .steps li, .cycle li, .stack-grid > div').forEach((el) => {
    el.classList.add('spot');
    el.addEventListener('pointermove', (e) => {
      const r = el.getBoundingClientRect();
      el.style.setProperty('--mx', `${e.clientX - r.left}px`);
      el.style.setProperty('--my', `${e.clientY - r.top}px`);
    });
  });

  // ---------- Magnetic primary buttons ----------
  if (!reduceMotion.matches) {
    document.querySelectorAll('.btn-primary').forEach((btn) => {
      btn.addEventListener('pointermove', (e) => {
        const r = btn.getBoundingClientRect();
        const x = e.clientX - r.left - r.width / 2;
        const y = e.clientY - r.top - r.height / 2;
        btn.style.transform = `translate(${x * 0.15}px, ${y * 0.3 - 2}px)`;
      });
      btn.addEventListener('pointerleave', () => { btn.style.transform = ''; });
    });
  }
}

// ---------- FAQ: animate open/close height ----------
document.querySelectorAll('.faq details').forEach((d) => {
  const summary = d.querySelector('summary');
  summary.addEventListener('click', (e) => {
    if (reduceMotion.matches || d.classList.contains('animating')) {
      if (d.classList.contains('animating')) e.preventDefault();
      return;
    }
    e.preventDefault();
    d.classList.add('animating');
    const collapsed = summary.offsetHeight;
    if (d.open) {
      const anim = d.animate({ height: [`${d.offsetHeight}px`, `${collapsed}px`] }, { duration: 240, easing: 'ease' });
      anim.onfinish = () => { d.open = false; d.classList.remove('animating'); };
    } else {
      d.open = true;
      const anim = d.animate({ height: [`${collapsed}px`, `${d.offsetHeight}px`] }, { duration: 300, easing: 'cubic-bezier(.2, .7, .2, 1)' });
      anim.onfinish = () => { d.classList.remove('animating'); };
    }
  });
});
