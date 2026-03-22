#!/usr/bin/env bash
#
# Builds a WordPress-installable zip of the Aurelines theme.
# Usage: ./build-theme-zip.sh
#

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
THEME_DIR="$SCRIPT_DIR/aurelines"
THEME_NAME="aurelines"

# Read version from style.css
VERSION=$(grep -m1 '^Version:' "$THEME_DIR/style.css" | sed 's/Version:[[:space:]]*//')
ZIP_NAME="${THEME_NAME}-${VERSION}.zip"
DIST_DIR="$SCRIPT_DIR/dist"

mkdir -p "$DIST_DIR"

# Remove old zip if exists
rm -f "$DIST_DIR/$ZIP_NAME"

cd "$SCRIPT_DIR"

zip -r "$DIST_DIR/$ZIP_NAME" "$THEME_NAME/" \
  -x "${THEME_NAME}/.DS_Store" \
  -x "${THEME_NAME}/**/.DS_Store" \
  -x "${THEME_NAME}/node_modules/*" \
  -x "${THEME_NAME}/.git/*" \
  -x "${THEME_NAME}/.gitignore"

echo ""
echo "Theme zip created: dist/$ZIP_NAME"
echo "Size: $(du -h "$DIST_DIR/$ZIP_NAME" | cut -f1)"
