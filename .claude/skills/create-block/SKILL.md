---
name: create-block
description: >
  Create custom WordPress Gutenberg blocks without Node.js, npm, or @wordpress/scripts.
  Uses vanilla JS with global wp.* objects and PHP render_callback for server-side rendering.
  Use this skill whenever the user wants to create, add, or register a Gutenberg block,
  a WordPress editor block, a dynamic block rendered by PHP, or any custom block
  for the WordPress block editor — especially when they mention avoiding build tools,
  not wanting npm/Node dependencies, wanting a lightweight approach, or working
  with server-side rendered (SSR) blocks. Also trigger when the user says
  "block plugin", "custom block without JSX", "register block type",
  "ServerSideRender", or "render_callback".
---

# Gutenberg Blocks Without Build Tools

Create fully functional WordPress Gutenberg blocks using only PHP and vanilla JavaScript.
No Node.js, no npm, no webpack, no `@wordpress/scripts` — just files that WordPress
can load directly.

## Why this works

WordPress loads its block editor libraries as global browser objects. Every package
available via `import { X } from '@wordpress/...'` in a build-tool setup is also
available as `wp.*` in the browser. The mapping:

| npm package              | Global object          | wp_register_script dependency |
|--------------------------|------------------------|-------------------------------|
| @wordpress/blocks        | wp.blocks              | wp-blocks                     |
| @wordpress/element       | wp.element             | wp-element                    |
| @wordpress/block-editor  | wp.blockEditor         | wp-block-editor               |
| @wordpress/components    | wp.components          | wp-components                 |
| @wordpress/server-side-render | wp.serverSideRender | wp-server-side-render        |
| @wordpress/data          | wp.data                | wp-data                       |
| @wordpress/hooks         | wp.hooks               | wp-hooks                      |
| @wordpress/i18n          | wp.i18n                | wp-i18n                       |
| @wordpress/api-fetch     | wp.apiFetch            | wp-api-fetch                  |

## Project structure

Every block lives in its own directory under `blocks/`. A central registry file
loads them all. This keeps blocks isolated and easy to add or remove.

```
my-plugin/
├── my-plugin.php                  ← Plugin entry point, requires register-blocks.php
└── blocks/
    ├── register-blocks.php        ← Central registry, lists all block slugs
    ├── my-first-block/
    │   ├── index.php              ← register_block_type() + render_callback
    │   ├── editor.js              ← wp.blocks.registerBlockType() — editor UI
    │   ├── style.css              ← Frontend styles
    │   └── editor.css             ← Editor-only styles (optional)
    └── my-second-block/
        ├── index.php
        ├── editor.js
        └── style.css
```

## Step-by-step: creating a new block

Follow these steps in order for every new block.

### 1. Plugin entry point (create once)

`my-plugin.php` — minimal, just loads the registry:

```php
<?php
/**
 * Plugin Name: My Custom Blocks
 * Description: Custom Gutenberg blocks — no build tools.
 * Version: 1.0.0
 */
defined('ABSPATH') || exit;
require_once plugin_dir_path(__FILE__) . 'blocks/register-blocks.php';
```

### 2. Central registry

`blocks/register-blocks.php` — single array of block slugs. Adding a block means
adding one string here and creating its directory.

```php
<?php
defined('ABSPATH') || exit;

function mcb_register_all_blocks() {
    $blocks = [
        'my-first-block',
        'my-second-block',
        // Add new blocks here
    ];

    foreach ($blocks as $block) {
        $file = __DIR__ . '/' . $block . '/index.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
add_action('init', 'mcb_register_all_blocks');
```

### 3. Block PHP file (index.php)

Each block's `index.php` does two things: registers assets and defines the render callback.

Key rules:
- Use a unique prefix for all function names and asset handles (e.g., `mcb_blockname_`).
- Declare the same `attributes` here as in `editor.js` — they must match.
- `render_callback` receives `$attributes` and `$content`; return an HTML string.
- Use `plugin_dir_url(__FILE__)` for asset URLs — this resolves correctly per-block.
- Use `filemtime()` for cache-busting version numbers.
- The function that registers the block should be called directly (not hooked to `init`)
  because `register-blocks.php` already runs inside an `init` hook.

```php
<?php
defined('ABSPATH') || exit;

function mcb_register_example_block() {
    $dir = __DIR__;
    $url = plugin_dir_url(__FILE__);

    wp_register_script(
        'mcb-example-editor',
        $url . 'editor.js',
        ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'],
        filemtime($dir . '/editor.js'),
        true
    );

    wp_register_style(
        'mcb-example-style',
        $url . 'style.css',
        [],
        filemtime($dir . '/style.css')
    );

    // Optional: editor-only style
    // wp_register_style('mcb-example-editor-style', $url . 'editor.css', [], filemtime($dir . '/editor.css'));

    register_block_type('mcb/example', [
        'api_version'     => 2,
        'editor_script'   => 'mcb-example-editor',
        'style'           => 'mcb-example-style',
        // 'editor_style' => 'mcb-example-editor-style',
        'attributes'      => [
            'title' => ['type' => 'string', 'default' => 'Hello'],
            'count' => ['type' => 'number', 'default' => 5],
        ],
        'render_callback' => 'mcb_render_example',
    ]);
}
mcb_register_example_block();

function mcb_render_example($attributes, $content) {
    $title = esc_html($attributes['title'] ?? 'Hello');
    ob_start();
    ?>
    <div class="mcb-example">
        <h2><?php echo $title; ?></h2>
    </div>
    <?php
    return ob_get_clean();
}
```

### 4. Block editor JS (editor.js)

This is where the editor UI lives. No JSX — use `wp.element.createElement` (aliased as `el`).

Key rules:
- Wrap everything in an IIFE: `(function(){ ... })();`
- Pull globals at the top: `var el = wp.element.createElement;` etc.
- `save` must return `null` — this tells Gutenberg the block is dynamic (PHP renders it).
- For live preview in the editor, use `wp.serverSideRender` (add `'wp-server-side-render'`
  to the script dependencies in PHP). This calls your `render_callback` via AJAX.
- Alternatively, build a manual preview with `el()` calls for instant feedback
  without server round-trips. Use this when the block is simple enough.
- Place controls in `InspectorControls` (sidebar panel) for a clean editor experience.

```js
(function () {
    var registerBlockType = wp.blocks.registerBlockType;
    var el                = wp.element.createElement;
    var Fragment          = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody         = wp.components.PanelBody;
    var TextControl       = wp.components.TextControl;
    var RangeControl      = wp.components.RangeControl;

    // Optional: for live PHP preview in editor
    // var ServerSideRender = wp.serverSideRender;

    registerBlockType('mcb/example', {
        title: 'Example Block',
        description: 'A sample block rendered by PHP.',
        icon: 'smiley',
        category: 'widgets',

        attributes: {
            title: { type: 'string', default: 'Hello' },
            count: { type: 'number', default: 5 },
        },

        edit: function (props) {
            var a   = props.attributes;
            var set = props.setAttributes;

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'Settings', initialOpen: true },
                        el(TextControl, {
                            label: 'Title',
                            value: a.title,
                            onChange: function (v) { set({ title: v }); },
                        }),
                        el(RangeControl, {
                            label: 'Count',
                            value: a.count,
                            onChange: function (v) { set({ count: v }); },
                            min: 1,
                            max: 20,
                        })
                    )
                ),

                // Option A: ServerSideRender (live PHP preview)
                // el(ServerSideRender, { block: 'mcb/example', attributes: a })

                // Option B: manual preview
                el('div', { className: 'mcb-example' },
                    el('h2', null, a.title)
                )
            );
        },

        save: function () {
            return null;
        },
    });
})();
```

### 5. Styles

`style.css` — loaded on both frontend and editor. Write all visual styles here.

`editor.css` (optional) — loaded only in the editor. Use for things like dashed
borders around the block to indicate its boundaries, or placeholder styling.

## Common wp.components reference

These are the most frequently used components, all available via `wp.components.*`:

| Component        | Purpose                                | Common props                              |
|------------------|----------------------------------------|-------------------------------------------|
| TextControl      | Single-line text input                 | label, value, onChange, placeholder       |
| TextareaControl  | Multi-line text input                  | label, value, onChange, rows              |
| RangeControl     | Numeric slider                         | label, value, onChange, min, max, step    |
| ToggleControl    | Boolean switch                         | label, checked, onChange                  |
| SelectControl    | Dropdown select                        | label, value, onChange, options           |
| ColorPicker      | Color chooser                          | color, onChangeComplete, disableAlpha    |
| PanelBody        | Collapsible sidebar section            | title, initialOpen                       |
| Button           | Clickable button                       | onClick, variant ('primary'/'secondary') |
| Placeholder      | Empty-state UI with icon               | icon, label, instructions                |

## Checklist for adding a new block

1. Create directory: `blocks/my-new-block/`
2. Create `index.php` with unique function prefix, attributes, and render_callback
3. Create `editor.js` with matching attributes, `save: () => null`, and editor UI
4. Create `style.css` for frontend styles
5. Add slug `'my-new-block'` to the `$blocks` array in `register-blocks.php`
6. Verify attribute definitions match between PHP and JS

## Common mistakes to avoid

- **Mismatched attributes** between PHP and JS — the block will silently ignore
  attributes that aren't declared on both sides.
- **Forgetting `save: () => null`** — if save returns markup, Gutenberg will store
  HTML in the database and validate it on load. Any change to the markup breaks
  existing blocks. Always return `null` for PHP-rendered blocks.
- **Missing script dependencies** — if you use `wp.serverSideRender` but don't list
  `'wp-server-side-render'` in `wp_register_script` deps, it will be `undefined`.
- **Calling `register_block_type` inside another `init` hook** — the registry file
  already runs inside `init`. Nesting causes double-registration or timing issues.
  Call your registration function directly from `index.php`.
- **Using `import`/`export` syntax** — this is vanilla JS, not a module. Use IIFEs
  and global `wp.*` objects. No ES modules, no JSX.
