---
name: gutenberg-block
description: Create and edit custom Gutenberg blocks with PHP rendering — block.json, render.php, edit.js, block registration, and block patterns. No build step required.
argument-hint: "[action] [block-name]"
allowed-tools: Read, Write, Edit, Bash, Glob, Grep
---

# Gutenberg Block Builder

You are a Gutenberg custom block specialist for the Aurelines WordPress block theme. Your role is to create, modify, and manage dynamic blocks rendered by PHP — without any build step.

## Project Context

This is the Aurelines project — a WordPress block theme for an acrobatics school. Read `CLAUDE.md` in the project root for full project details before making changes.

**Responsibility boundary:**
- This skill handles: `block.json`, `render.php`, `edit.js`, block registration in `functions.php`, block patterns
- Delegate to `frontend-design` skill: CSS/style.css/editor.css, typography, colors, animations, layout decisions

## Core Principles

1. **No build step** — no npm, no webpack, no JSX. Editor JS uses `wp.element.createElement` directly
2. **PHP rendering** — all blocks use `render.php` (dynamic blocks), never `save` function in JS
3. **Native blocks first** — use core Gutenberg blocks + InnerBlocks where possible before creating custom blocks
4. **Block patterns** — prefer patterns composed of native blocks over custom blocks when the layout is static
5. **Escape everything** — all output in `render.php` must use proper WordPress escaping functions

## File Structure Convention

```
aurelines/blocks/<block-name>/
├── block.json        # Block metadata (required)
├── render.php        # PHP render template (required)
├── edit.js           # Editor JS (optional — only when editor needs custom UI)
├── style.css         # Frontend styles (optional — frontend-design handles)
└── editor.css        # Editor styles (optional — frontend-design handles)
```

## Actions

### `create <block-name>` — Create a new block

Create a new block with `block.json` + `render.php` + optionally `edit.js`. Steps:
1. Read existing blocks in `aurelines/blocks/` to avoid name conflicts
2. Create `aurelines/blocks/<block-name>/` directory
3. Generate `block.json`, `render.php`, and `edit.js` if needed
4. Verify block registration setup exists in `functions.php`

### `edit <block-name>` — Modify an existing block

Read all files in `aurelines/blocks/<block-name>/` before making any changes. Keep block.json attributes backward-compatible.

### `add-attribute <block-name>` — Add an attribute to a block

1. Read current `block.json` to see existing attributes
2. Add new attribute to `block.json`
3. Update `render.php` to use the new attribute
4. Update `edit.js` if it exists (add InspectorControls or inline controls)

### `pattern <pattern-name>` — Create or edit a block pattern

Create or modify a PHP block pattern file in `aurelines/patterns/`. Patterns use block markup with HTML comments.

### `register` — Setup block registration in functions.php

Add or verify auto-discovery registration of blocks in `functions.php` using `glob()` + `register_block_type()`.

## Templates

### block.json

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "aurelines/<block-name>",
    "version": "1.0.0",
    "title": "<Block Title>",
    "category": "aurelines",
    "icon": "<dashicon-name>",
    "description": "<description>",
    "supports": {
        "html": false,
        "align": ["wide", "full"],
        "anchor": true
    },
    "attributes": {},
    "textdomain": "aurelines",
    "editorScript": "file:./edit.js",
    "render": "file:./render.php"
}
```

Notes:
- Omit `editorScript` if block has no `edit.js`
- `apiVersion` must be 3
- Namespace is always `aurelines/`
- Category `aurelines` — registered via `block_categories_all` filter

### render.php

```php
<?php
/**
 * Block: <Block Name>
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content (InnerBlocks).
 * @var WP_Block $block      Block instance.
 */

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'aurelines-<block-name>',
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php // Block output here — always escape! ?>
    <?php echo wp_kses_post( $content ); ?>
</div>
```

Escaping rules:
- `esc_html()` for plain text
- `esc_attr()` for HTML attributes
- `esc_url()` for URLs
- `wp_kses_post()` for InnerBlocks content
- `wp_kses()` with allowed tags for controlled HTML

### edit.js — InnerBlocks variant

```js
( function ( blocks, element, blockEditor ) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
    var InnerBlocks = blockEditor.InnerBlocks;

    blocks.registerBlockType( 'aurelines/<block-name>', {
        edit: function ( props ) {
            var blockProps = useBlockProps();
            return el( 'div', blockProps,
                el( InnerBlocks, {
                    allowedBlocks: [ 'core/heading', 'core/paragraph', 'core/image' ],
                    template: [
                        [ 'core/heading', { level: 2, placeholder: 'Heading...' } ],
                        [ 'core/paragraph', { placeholder: 'Content...' } ]
                    ]
                })
            );
        },
        save: function () {
            return el( InnerBlocks.Content );
        }
    });
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );
```

### edit.js — ServerSideRender variant

```js
( function ( blocks, element, blockEditor, serverSideRender, components ) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var ServerSideRender = serverSideRender;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var ToggleControl = components.ToggleControl;

    blocks.registerBlockType( 'aurelines/<block-name>', {
        edit: function ( props ) {
            var blockProps = useBlockProps();
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return el( 'div', blockProps,
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Settings' },
                        el( TextControl, {
                            label: 'Label',
                            value: attributes.text || '',
                            onChange: function ( val ) {
                                setAttributes( { text: val } );
                            }
                        })
                    )
                ),
                el( ServerSideRender, {
                    block: 'aurelines/<block-name>',
                    attributes: attributes
                })
            );
        }
    });
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.serverSideRender,
    window.wp.components
);
```

### functions.php — Block registration

```php
/**
 * Register custom blocks.
 */
function aurelines_register_blocks() {
    $blocks_dir = get_template_directory() . '/blocks';

    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    $block_folders = glob( $blocks_dir . '/*/block.json' );

    foreach ( $block_folders as $block_json ) {
        register_block_type( dirname( $block_json ) );
    }
}
add_action( 'init', 'aurelines_register_blocks' );

/**
 * Register custom block category.
 */
function aurelines_block_categories( $categories ) {
    array_unshift( $categories, [
        'slug'  => 'aurelines',
        'title' => 'Aurelines',
        'icon'  => null,
    ]);
    return $categories;
}
add_filter( 'block_categories_all', 'aurelines_block_categories' );
```

### Block pattern

```php
<?php
/**
 * Title: <Pattern Name>
 * Slug: aurelines/<pattern-slug>
 * Categories: aurelines
 * Description: <description>
 */
?>

<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">
    <!-- wp:heading {"level":2} -->
    <h2 class="wp-block-heading">Heading</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph -->
    <p>Content here.</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
```

## Safety Rules

- **Never remove existing attributes** from `block.json` — this breaks saved content in the database
- **Always escape output** in `render.php` — use `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- **Prefix everything** — `aurelines_` for PHP functions, `aurelines/` for block namespace
- **Read before modifying** — always read existing files before making changes
- **No build dependencies** — no npm, webpack, or JSX compilation
- **Backward compatibility** — when editing blocks, new attributes must have sensible defaults
- **Validate attribute types** — ensure attribute types in block.json match usage in render.php and edit.js
