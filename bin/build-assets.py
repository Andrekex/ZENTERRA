#!/usr/bin/env python3
"""Minify theme/assets/styles.css into styles.min.css.

Run after editing styles.css:  python3 bin/build-assets.py
The first line of styles.min.css records a fingerprint of styles.css. The theme only uses the
minified file when that fingerprint still matches, so a missed rebuild falls back to the
readable file instead of serving stale styles.

Safe minification only: comments and extra whitespace are removed; quoted strings and
url(...) values (the inline SVGs) are left untouched.
"""
import hashlib
import os
import re

ASSETS = os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'theme', 'assets')
SRC, OUT = os.path.join(ASSETS, 'styles.css'), os.path.join(ASSETS, 'styles.min.css')

css = open(SRC, encoding='utf-8').read()
# Split into protected chunks (strings, url(...)) and plain CSS.
parts = re.split(r'("(?:[^"\\]|\\.)*"|\'(?:[^\'\\]|\\.)*\'|url\([^)"\']*\))', css)
out = []
for i, part in enumerate(parts):
    if i % 2:            # protected chunk
        out.append(part)
        continue
    part = re.sub(r'/\*.*?\*/', '', part, flags=re.S)   # comments
    part = re.sub(r'\s+', ' ', part)                     # runs of whitespace
    part = re.sub(r'\s*([{};,])\s*', r'\1', part)        # around punctuation that never needs it
    part = re.sub(r';}', '}', part)                      # last semicolon in a block
    out.append(part)
minified = ''.join(out).strip()
# A comment can be split around a quoted string; drop anything still left.
minified = re.sub(r'/\*.*?\*/', '', minified, flags=re.S)
fingerprint = hashlib.md5(css.encode('utf-8')).hexdigest()
open(OUT, 'w', encoding='utf-8').write(f'/*! src:{fingerprint} */\n' + minified + '\n')
print(f'styles.css {len(css.encode()):,} bytes -> styles.min.css {len(minified.encode()):,} bytes')
