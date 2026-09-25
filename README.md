# Zenterra WordPress theme

One-page WordPress theme for Zenterra, an AI-first studio building websites and AI solutions with Claude. It is hosted on Hostiq's WordPress plan.

This repo holds only the theme. WordPress core, plugins, uploads and the database live on the server and are managed from wp-admin.

## Layout

```
theme/                    → deployed to wp-content/themes/zenterra
  style.css               theme header (name, version)
  functions.php           setup, scripts and styles, meta tags
  header.php, footer.php  site header and footer
  front-page.php          the homepage (all sections)
  index.php               posts, pages, archives, 404
  inc/contact.php         contact form handler (sends via wp_mail)
  assets/                 styles.css, main.js, favicon.svg
deploy.sh                 runs on the server, installs theme/
.github/workflows/        CI: PHP lint on every push and PR; deploy on main
```

## Editing content

Homepage text, prices and FAQ are in `theme/front-page.php`. Edit the file, push to `main`, and CI deploys it. Contact form options are at the top of `theme/inc/contact.php`.

Set these in wp-admin:
- **Settings → General:** site title and tagline, which make up the browser tab title.
- **Appearance → Customize → Contact form:** where requests are sent. The default is the admin email.
- **Appearance → Customize → Site Identity:** Site Icon. If none is set, the theme's favicon is used.

On shared hosting, `wp_mail` delivery is more reliable with an SMTP plugin such as WP Mail SMTP.

## How deploys work

Every push to `main` runs these steps:
1. GitHub Actions checks PHP syntax.
2. It connects to Hostiq over SSH.
3. It updates the repo copy in `~/repositories/ZENTERRA`.
4. It runs `deploy.sh`, which swaps in `wp-content/themes/zenterra` in one step.

The page cache is purged when WP-CLI is available.

Deploys never activate the theme. Activate it once, in **Appearance → Themes**.

### GitHub secrets

| Secret | Value |
|---|---|
| `HOSTIQ_SSH_KEY` | private key GitHub Actions uses to log into the server |
| `HOSTIQ_HOST` | SSH host |
| `HOSTIQ_USER` | SSH user |
| `HOSTIQ_WP_ROOT` | WordPress folder (the one with `wp-config.php`), full path |
| `HOSTIQ_PORT` | optional, default `22` |
| `HOSTIQ_REPO_DIR` | optional, default `~/repositories/ZENTERRA` |

### Manual deploy (on the server)

```sh
cd ~/repositories/ZENTERRA && git pull && bash deploy.sh /full/path/to/wordpress
```
