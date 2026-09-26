// Animated page background: abstract code lines stream past a "review" scanner.
// Each line lights up violet as it crosses the scanner and keeps a fading tint
// afterwards — "every line reviewed". Scrolling moves the stream (three depth
// layers at different speeds) and makes the scanner glow brighter.
(() => {
  const canvas = document.getElementById('zt-code');
  const bg = document.getElementById('zt-bg');
  if (!canvas || !bg || !canvas.getContext) return;

  const ctx = canvas.getContext('2d');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const darkQuery = window.matchMedia('(prefers-color-scheme: dark)');

  // Far → near. speed: share of scroll distance; drift: px/s when idle.
  const LAYERS = [
    { speed: 0.14, drift: 12, h: 3, weight: 0.45, gap: 22, colW: 300, seed: 11 },
    { speed: 0.32, drift: 20, h: 4, weight: 0.7, gap: 27, colW: 360, seed: 23 },
    { speed: 0.58, drift: 32, h: 5, weight: 1, gap: 32, colW: 430, seed: 37 },
  ];
  const PERIOD = 1800; // height of the repeating pattern, px

  let W = 0;
  let H = 0;
  let dpr = 1;
  let layers = [];
  let colors = null;
  let lastScroll = window.scrollY;
  let lastTime = performance.now();
  let velocity = 0; // 0–1, decays after scrolling stops
  let drift = 0; // accumulated idle drift, seconds
  let raf = 0;
  let frame = 0;
  let lastScrollAt = 0;

  // Small deterministic PRNG, so the pattern is the same on every load.
  const prng = (seed) => () => {
    seed = (seed + 0x6d2b79f5) | 0;
    let t = Math.imul(seed ^ (seed >>> 15), 1 | seed);
    t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
    return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
  };

  const hexToRgb = (hex) => {
    const h = hex.replace('#', '').trim();
    const n = parseInt(h.length === 3 ? h.split('').map((c) => c + c).join('') : h, 16);
    return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
  };

  function readColors() {
    const cs = getComputedStyle(document.documentElement);
    const theme = document.documentElement.dataset.theme;
    const dark = theme ? theme === 'dark' : darkQuery.matches;
    colors = {
      dark,
      line: hexToRgb(cs.getPropertyValue('--muted') || '#5e5b6e'),
      accent: hexToRgb(cs.getPropertyValue('--accent') || '#5c16ff'),
      base: dark ? 0.16 : 0.12,
    };
  }

  // Lines laid out like code: blocks, indentation, blank lines between blocks.
  function build() {
    layers = LAYERS.map((L) => {
      const r = prng(L.seed);
      const lines = [];
      const cols = Math.ceil(W / L.colW) + 1;
      for (let c = 0; c < cols; c++) {
        const x0 = c * L.colW + (r() - 0.5) * 70;
        let y = r() * L.gap * 5;
        let indent = 0;
        while (y < PERIOD) {
          const blockLen = 3 + Math.floor(r() * 8);
          for (let i = 0; i < blockLen && y < PERIOD; i++) {
            const step = r();
            indent = Math.max(0, Math.min(4, indent + (step < 0.28 ? 1 : step < 0.5 ? -1 : 0)));
            const segments = r() < 0.35 ? 2 : 1;
            let x = x0 + indent * 16;
            for (let s = 0; s < segments; s++) {
              const w = 22 + r() * (s ? 110 : 180);
              lines.push({ x, y, w, tick: s === segments - 1 && r() < 0.3 });
              x += w + 9;
            }
            y += L.gap;
          }
          y += L.gap * (1 + Math.floor(r() * 2));
        }
      }
      return { ...L, lines };
    });
  }

  function resize() {
    const w = window.innerWidth;
    const h = window.innerHeight;
    // Drawn at ~half resolution: the browser's smooth upscaling gives a soft blur for free
    // (cheaper than a CSS blur filter, which would re-blur the whole screen every frame).
    dpr = 0.55;
    canvas.width = Math.round(w * dpr);
    canvas.height = Math.round(h * dpr);
    canvas.style.width = `${w}px`;
    canvas.style.height = `${h}px`;
    const rebuild = w !== W;
    W = w;
    H = h;
    if (rebuild) build();
  }

  const smooth = (x) => x * x * (3 - 2 * x);

  function roundRect(x, y, w, h) {
    const r = h / 2;
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.arcTo(x + w, y, x + w, y + h, r);
    ctx.arcTo(x + w, y + h, x, y + h, r);
    ctx.arcTo(x, y + h, x, y, r);
    ctx.arcTo(x, y, x + w, y, r);
    ctx.fill();
  }

  function draw(now) {
    const scrollY = window.scrollY;
    const scanY = H * 0.58;
    const band = Math.max(70, H * 0.09);
    const [lr, lg, lb] = colors.line;
    const [ar, ag, ab] = colors.accent;
    // Text sits in a left-aligned column inside the 1120px container; keep lines faint there.
    const zoneL = Math.max(0, (W - 1120) / 2) + (W >= 720 ? 32 : 16);
    const zoneR = zoneL + Math.min(760, W - zoneL * 2);

    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    ctx.clearRect(0, 0, W, H);

    // Scanner band and line
    const glow = 0.05 + velocity * 0.1;
    const grad = ctx.createLinearGradient(0, scanY - band * 1.6, 0, scanY + band * 1.6);
    grad.addColorStop(0, `rgba(${ar},${ag},${ab},0)`);
    grad.addColorStop(0.5, `rgba(${ar},${ag},${ab},${glow})`);
    grad.addColorStop(1, `rgba(${ar},${ag},${ab},0)`);
    ctx.fillStyle = grad;
    ctx.fillRect(0, scanY - band * 1.6, W, band * 3.2);

    const lineGrad = ctx.createLinearGradient(0, 0, W, 0);
    lineGrad.addColorStop(0, `rgba(${ar},${ag},${ab},0)`);
    lineGrad.addColorStop(0.5, `rgba(${ar},${ag},${ab},${0.28 + velocity * 0.3})`);
    lineGrad.addColorStop(1, `rgba(${ar},${ag},${ab},0)`);
    ctx.fillStyle = lineGrad;
    ctx.fillRect(0, scanY - 0.5, W, 1);

    // Scan head running along the scanner
    const headX = ((drift * 180 + scrollY * 0.6) % (W + 300)) - 150;
    const head = ctx.createRadialGradient(headX, scanY, 0, headX, scanY, 90);
    head.addColorStop(0, `rgba(${ar},${ag},${ab},${0.35 + velocity * 0.3})`);
    head.addColorStop(1, `rgba(${ar},${ag},${ab},0)`);
    ctx.fillStyle = head;
    ctx.fillRect(headX - 90, scanY - 90, 180, 180);

    // Code lines
    for (const L of layers) {
      const offset = scrollY * L.speed + drift * L.drift;
      for (const ln of L.lines) {
        let y = (((ln.y - offset) % PERIOD) + PERIOD) % PERIOD;
        for (; y < H + 10; y += PERIOD) {
          if (y < -10) continue;
          const d = y - scanY;
          const inBand = Math.max(0, 1 - Math.abs(d) / band); // crossing the scanner
          const reviewed = d < 0 ? Math.max(0, 1 - -d / (H * 0.55)) * 0.55 : 0; // already passed
          const k = Math.max(smooth(inBand), reviewed);
          // Faint behind the text column, full strength beside it
          const mid = ln.x + ln.w / 2;
          const outside = Math.max(zoneL - mid, mid - zoneR, 0);
          const place = 0.22 + 0.78 * smooth(Math.min(1, outside / 140));
          const alpha = (colors.base + k * 0.42) * L.weight * place;
          if (alpha < 0.01) continue;
          const r = Math.round(lr + (ar - lr) * k);
          const g = Math.round(lg + (ag - lg) * k);
          const b = Math.round(lb + (ab - lb) * k);
          ctx.fillStyle = `rgba(${r},${g},${b},${alpha})`;
          roundRect(ln.x, y - L.h / 2, ln.w * (1 + inBand * 0.08), L.h);

          // A small tick on some lines as they get reviewed
          if (ln.tick && inBand > 0.35 && L.weight > 0.6) {
            const tx = ln.x + ln.w + 12;
            ctx.strokeStyle = `rgba(${ar},${ag},${ab},${inBand * 0.9 * place})`;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.beginPath();
            ctx.moveTo(tx, y);
            ctx.lineTo(tx + 3.5, y + 3.5);
            ctx.lineTo(tx + 10, y - 4);
            ctx.stroke();
          }
        }
      }
    }
  }

  function tick(now) {
    raf = requestAnimationFrame(tick);
    const dt = Math.min(0.1, (now - lastTime) / 1000);
    lastTime = now;

    const scrollY = window.scrollY;
    const dy = Math.abs(scrollY - lastScroll);
    lastScroll = scrollY;
    if (dy > 0) lastScrollAt = now;
    velocity += (Math.min(1, dy / 60) - velocity) * 0.12;
    drift += dt;

    // Idle: draw at ~30fps to save battery; full rate while scrolling
    frame++;
    if (now - lastScrollAt > 800 && frame % 2) return;

    draw(now);
    bg.style.setProperty('--v', velocity.toFixed(3));
  }

  function start() {
    if (raf || reduceMotion.matches || document.hidden) return;
    lastTime = performance.now();
    raf = requestAnimationFrame(tick);
  }

  function stop() {
    cancelAnimationFrame(raf);
    raf = 0;
  }

  readColors();
  resize();
  draw(performance.now()); // static frame (also what reduced-motion visitors see)

  window.addEventListener('resize', () => { resize(); draw(performance.now()); });
  document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));
  darkQuery.addEventListener('change', () => { readColors(); draw(performance.now()); });
  new MutationObserver(() => { readColors(); draw(performance.now()); })
    .observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
  reduceMotion.addEventListener('change', () => (reduceMotion.matches ? stop() : start()));

  start();
})();
