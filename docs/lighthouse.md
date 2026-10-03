# Lighthouse scores

Lighthouse 13.5.0, default mobile profile (mid-range phone, throttled 4G), homepage.
Each figure is the median of the runs listed.

## 4 October 2026: load speed and SEO quick wins (theme 1.17.2 → 1.18.0)

### Live site before (https://zenterrait.com/, theme 1.17.2, 3 runs)

| Performance | SEO | Accessibility | Best Practices | FCP | LCP | TBT | CLS |
|---|---|---|---|---|---|---|---|
| 97 (79, 97, 97) | 92 | 94 | 100 | 1.96 s | 2.28 s | 0 ms | 0.001 |

SEO was 92 because the page had no `<title>`: Rank Math prints the title on this server, and the
theme had told Rank Math to skip its pages. Accessibility lost points for the missing title and
for low-contrast ticker text.

### Same machine, same conditions: before vs after (local copy, 5 runs each)

| Version | Performance | SEO | Accessibility | Best Practices | FCP | LCP | TBT | CLS | Speed Index | Requests | Transfer |
|---|---|---|---|---|---|---|---|---|---|---|---|
| 1.17.2 (before) | 90 (91, 90, 90, 90, 89) | 100 | 97 | 100 | 2.70 s | 3.08 s | 10 ms | 0.001 | 2.70 s | 19 | 380 KB |
| 1.18.0 (after) | 99 (98, 99, 99, 99, 99) | 100 | 100 | 100 | 1.20 s | 2.10 s | 0 ms | 0.000 | 1.44 s | 14 | 229 KB |

Ukrainian homepage (`/uk/`) after: Performance 96, SEO 100, Accessibility 100, Best Practices 100.

The local test server does not compress responses and (in these runs) had WordPress cron
switched off, so absolute times differ from the live site; the comparison between versions is
like for like.

### Live site after

To be recorded once 1.18.0 is uploaded to zenterrait.com.

### What changed

- The theme prints its own `<title>` on its pages (was missing on the live site).
- The hero intro paragraph (the LCP element) is visible from the first paint instead of fading in.
- Fonts: one variable font file per family and alphabet (10 files, 284 KB) instead of the same
  file saved under 3–4 names (34 files, 912 KB); `@font-face` CSS inlined; two fonts preloaded.
- Minified stylesheet; long browser-cache lifetimes for fonts, CSS, JS and images (`assets/.htaccess`).
- Startup script reads layout once instead of once per element; the animated background starts
  after the page has loaded.
- Footer logo lazy-loads; logos have alt text; ticker text contrast fixed.
- Regular WordPress pages get a meta description from their excerpt when nothing else provides one.

### How to re-run

```sh
~/Projects/ZENTERRA/local/lighthouse/run.sh https://zenterrait.com/ live-after 3
```
