// Where contact requests are sent. Replace with the domain mailbox once it exists.
const CONTACT_EMAIL = 'mrandrekex@gmail.com';

// ---------- Contact email links ----------
document.querySelectorAll('.contact-email').forEach((a) => {
  a.href = `mailto:${CONTACT_EMAIL}`;
  a.textContent = CONTACT_EMAIL;
});

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

// ---------- CTA buttons that preselect a topic ----------
const form = document.getElementById('contact-form');

document.querySelectorAll('[data-topic]').forEach((el) => {
  el.addEventListener('click', () => { form.elements.topic.value = el.dataset.topic; });
});

// ---------- Contact form → prefilled email ----------
const note = document.getElementById('form-note');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  const f = form.elements;
  const required = [f.name, f.email, f.goal];
  let firstInvalid = null;

  required.forEach((field) => {
    const ok = field.value.trim() !== '' && field.checkValidity();
    field.setAttribute('aria-invalid', String(!ok));
    if (!ok && !firstInvalid) firstInvalid = field;
  });

  if (firstInvalid) {
    note.textContent = 'Please fill in your name, a valid email and your goal.';
    note.classList.add('error');
    firstInvalid.focus();
    return;
  }

  const body = [
    `Name: ${f.name.value.trim()}`,
    `Email: ${f.email.value.trim()}`,
    `Service: ${f.topic.value}`,
    `Budget: ${f.budget.value}`,
    `Deadline: ${f.deadline.value.trim() || '—'}`,
    '',
    'Business and goal:',
    f.goal.value.trim(),
    '',
    `Sites I like: ${f.examples.value.trim() || '—'}`,
  ].join('\n');

  const subject = `Project request: ${f.topic.value} — ${f.name.value.trim()}`;
  window.location.href = `mailto:${CONTACT_EMAIL}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

  note.classList.remove('error');
  note.textContent = 'Your email app should open now. If it doesn\'t, write to us directly at ' + CONTACT_EMAIL + '.';
});

// ---------- Footer year ----------
document.getElementById('year').textContent = new Date().getFullYear();
