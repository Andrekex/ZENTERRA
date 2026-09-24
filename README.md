# Zenterra website

Static one-page site for Zenterra, an AI-first studio building websites and AI solutions with Claude.

- `index.html` — all page content
- `assets/styles.css` — styles (light/dark themes via CSS variables)
- `assets/main.js` — mobile menu, theme toggle, pricing tabs, contact form
- `assets/favicon.svg` — logo mark

No build step. Open `index.html` in a browser, or serve locally:

```sh
python3 -m http.server 8000
```

The contact form opens the visitor's email app with their answers prefilled. The recipient address is `CONTACT_EMAIL` at the top of `assets/main.js`. Change it once the domain mailbox exists.

Deploys as-is to any static host (GitHub Pages, Netlify, Cloudflare Pages).
