const I18N = window.ZT_I18N || {};

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
  menuBtn.setAttribute('aria-label', open ? (I18N.closeMenu || 'Close menu') : (I18N.openMenu || 'Open menu'));
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
      note.textContent = I18N.invalid || 'Please fill in your name, a valid email and your goal.';
      note.className = 'form-note small error';
      firstInvalid.focus();
      return;
    }

    btn.disabled = true;
    btn.textContent = I18N.sending || 'Sending…';
  });
}

// ---------- Motion ----------
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

// Header shadow once the page is scrolled
const header = document.querySelector('.site-header');
const toTop = document.getElementById('to-top');
const onScroll = () => {
  const y = window.scrollY;
  header.classList.toggle('scrolled', y > 8);
  if (toTop) {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    toTop.classList.toggle('is-shown', y > window.innerHeight * 0.6);
    toTop.style.setProperty('--p', max > 0 ? Math.min(1, y / max).toFixed(3) : 0);
  }
};
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

// Reveal elements every time they scroll into view, with a direction per element type.
// [selector, direction]; a list of directions is applied by position within the group.
const REVEAL = [
  ['.section-head', 'left'],
  ['.table-wrap', 'zoom'],
  ['.callout', 'left'],
  ['.principles h3', 'left'],
  ['.principle', 'tilt'],
  ['.service', ['left', 'up', 'right']],
  ['.audiences h3', 'left'],
  ['.chips li', 'pop'],
  ['.stack h3', 'left'],
  ['.stack-grid > div', 'tilt'],
  ['.tabs', 'left'],
  ['.price', 'zoom'],
  ['.terms h3', 'left'],
  ['.terms-list li', 'left'],
  ['.steps li', 'left'],
  ['.cycle li', 'left'],
  ['.quality-grid .card', ['left', 'right']],
  ['.agencies-copy > *', 'left'],
  ['.wl-visual', 'right'],
  ['.faq details', 'right'],
  ['.contact-inner > div', 'left'],
  ['.contact-inner .form', 'right'],
  ['.entry', 'up'],
];

function stagger(el) {
  const siblings = [...el.parentElement.children].filter((c) => c.classList.contains('reveal'));
  el.style.setProperty('--delay', `${Math.min(siblings.indexOf(el), 7) * 80}ms`);
}

// Once the entrance finishes, switch to quick hover transitions (no delay).
function settleAfterReveal(el) {
  el.addEventListener('transitionend', (e) => {
    if (e.target === el && e.propertyName === 'transform' && el.classList.contains('is-visible')) {
      el.classList.add('settled');
    }
  });
}

// Prices count up from zero when their card appears ("$800–1,500" → 0 … 800, 0 … 1,500)
function countUp(card) {
  const tag = card.querySelector('.price-tag');
  const node = tag && tag.firstChild;
  if (!node || node.nodeType !== Node.TEXT_NODE) return;
  const original = tag.dataset.price || (tag.dataset.price = node.nodeValue);
  const targets = (original.match(/\d[\d,]*/g) || []).map((n) => Number(n.replace(/,/g, '')));
  if (!targets.length) return;
  const delay = parseInt(card.style.getPropertyValue('--delay'), 10) || 0;
  const start = performance.now() + delay + 150;
  const duration = 1000;
  const step = (now) => {
    const p = Math.max(0, Math.min(1, (now - start) / duration));
    const eased = 1 - Math.pow(1 - p, 3);
    let i = 0;
    node.nodeValue = original.replace(/\d[\d,]*/g, () => Math.round(targets[i++] * eased).toLocaleString('en-US'));
    if (p < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

// Called whenever a revealed element comes into view
function onShown(el) {
  if (el.classList.contains('price')) countUp(el);
}

// Replay the reveal on a group that is already on screen (used by the pricing tabs)
function replayReveal(els) {
  if (reduceMotion.matches) return;
  els.forEach((el) => el.classList.remove('is-visible', 'settled'));
  void document.body.offsetWidth;
  els.forEach((el) => { el.classList.add('is-visible'); onShown(el); });
}

if (!reduceMotion.matches && 'IntersectionObserver' in window) {
  const items = [];
  REVEAL.forEach(([selector, dir]) => {
    document.querySelectorAll(selector).forEach((el, i) => {
      el.dataset.reveal = Array.isArray(dir) ? dir[i % dir.length] : dir;
      items.push(el);
    });
  });

  // Show at 15% visible; reset only once fully off screen, so the reset is never seen.
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(({ target, isIntersecting, intersectionRatio }) => {
      if (isIntersecting && intersectionRatio >= 0.15) {
        if (!target.classList.contains('is-visible')) onShown(target);
        target.classList.add('is-visible');
      } else if (!isIntersecting) {
        target.classList.remove('is-visible', 'settled');
      }
    });
  }, { threshold: [0, 0.15] });

  // Index the contents of cards so they can cascade in after the card lands.
  document.querySelectorAll('.service .checks, .quality-grid .checks, .stack-grid > div, .principle, .price, .compare tbody').forEach((group) => {
    [...group.children].forEach((child, i) => child.style.setProperty('--i', i));
  });

  // Elements already on screen start visible, so nothing flashes on load.
  items.forEach((el) => {
    const r = el.getBoundingClientRect();
    const onScreen = r.top < window.innerHeight && r.bottom > 0;
    el.classList.add('reveal');
    if (onScreen) el.classList.add('is-visible', 'settled');
  });
  items.forEach((el) => { stagger(el); settleAfterReveal(el); observer.observe(el); });

  // Replay the hero entrance whenever you scroll back up to it.
  const hero = document.querySelector('.hero');
  if (hero) {
    new IntersectionObserver(([entry]) => {
      hero.classList.toggle('hero-reset', !entry.isIntersecting);
    }).observe(hero);
  }
}

// ---------- Page background follows scroll (and the pointer on desktop) ----------
const bg = document.getElementById('zt-bg');
if (bg && !reduceMotion.matches) {
  let queued = false;
  const paint = () => {
    queued = false;
    const y = window.scrollY;
    const max = document.documentElement.scrollHeight - window.innerHeight;
    bg.style.setProperty('--s', (max > 0 ? Math.min(1, y / max) : 0).toFixed(4));
    bg.style.setProperty('--gy', ((y * 0.3) % 28).toFixed(2));
  };
  const queue = () => { if (!queued) { queued = true; requestAnimationFrame(paint); } };
  window.addEventListener('scroll', queue, { passive: true });
  window.addEventListener('resize', queue);
  paint();

  if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    window.addEventListener('pointermove', (e) => {
      bg.style.setProperty('--px', ((e.clientX / window.innerWidth) * 2 - 1).toFixed(3));
      bg.style.setProperty('--py', ((e.clientY / window.innerHeight) * 2 - 1).toFixed(3));
    }, { passive: true });
  }
}

// ---------- Spotlight border on cards (fine pointers) ----------
if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
  document.querySelectorAll('.card:not(.form), .steps li, .cycle li, .stack-grid > div').forEach((el) => {
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

    // ---------- 3D tilt toward the cursor (cards only, not the form) ----------
    document.querySelectorAll('.service, .price, .principle, .quality-grid .card, .stack-grid > div, .steps li').forEach((el) => {
      el.classList.add('tilt');
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        el.style.setProperty('--rx', `${(-y * 8).toFixed(2)}deg`);
        el.style.setProperty('--ry', `${(x * 10).toFixed(2)}deg`);
      });
      el.addEventListener('pointerleave', () => {
        el.style.setProperty('--rx', '0deg');
        el.style.setProperty('--ry', '0deg');
      });
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
