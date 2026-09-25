#!/usr/bin/env bash
# Runs on the Hostiq server from the repo checkout: installs theme/ as wp-content/themes/zenterra.
# Only the theme folder is touched; WordPress core, plugins, uploads and the database are left alone.
set -euo pipefail

wp_root="${1:?usage: deploy.sh <WordPress folder, e.g. ~/public_html>}"
themes="$wp_root/wp-content/themes"
cd "$(dirname "$0")"

if [ ! -d "$themes" ]; then
  echo "No $themes here. Is $wp_root the folder with wp-config.php?" >&2
  exit 1
fi

# Copy next to the live theme, then swap, so visitors never see a half-copied theme.
rm -rf "$themes/zenterra.new" "$themes/zenterra.old"
cp -R theme "$themes/zenterra.new"
[ -d "$themes/zenterra" ] && mv "$themes/zenterra" "$themes/zenterra.old"
mv "$themes/zenterra.new" "$themes/zenterra"
rm -rf "$themes/zenterra.old"

# Purge the page cache when WP-CLI and LiteSpeed Cache are available, so changes show right away.
if command -v wp >/dev/null 2>&1; then
  wp --path="$wp_root" litespeed-purge all >/dev/null 2>&1 || wp --path="$wp_root" cache flush >/dev/null 2>&1 || true
fi

echo "Deployed zenterra theme $(git rev-parse --short HEAD) to $themes/zenterra"
