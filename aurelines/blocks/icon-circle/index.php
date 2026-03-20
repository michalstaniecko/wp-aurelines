<?php
/**
 * Aurelines Icon Circle Block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the icon-circle block.
 */
function aurelines_icon_circle_register() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_register_script(
		'aurelines-icon-circle-editor',
		$theme_uri . '/blocks/icon-circle/editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
		filemtime( $theme_dir . '/blocks/icon-circle/editor.js' ),
		true
	);

	wp_register_style(
		'aurelines-icon-circle-editor',
		$theme_uri . '/blocks/icon-circle/editor.css',
		array(),
		filemtime( $theme_dir . '/blocks/icon-circle/editor.css' )
	);

	register_block_type( 'aurelines/icon-circle', array(
		'editor_script'   => 'aurelines-icon-circle-editor',
		'editor_style'    => 'aurelines-icon-circle-editor',
		'render_callback' => 'aurelines_icon_circle_render',
		'attributes'      => array(
			'icon' => array(
				'type'    => 'string',
				'default' => 'fire',
			),
		),
	) );
}
add_action( 'init', 'aurelines_icon_circle_register' );

/**
 * Render the icon-circle block on the frontend.
 */
function aurelines_icon_circle_render( $attributes ) {
	$allowed = array( 'fire', 'shield', 'growth' );
	$icon    = in_array( $attributes['icon'], $allowed, true )
		? $attributes['icon']
		: 'fire';

	$svgs = array(
		'fire'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12c2-2.96 0-7-1-8 0 3.038-1.773 4.741-3 6-1.226 1.26-2 3.24-2 5a6 6 0 1 0 12 0c0-1.532-1.056-3.94-2-5-1.786 3-2.791 3-4 2z"/></svg>',
		'shield' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
		'growth' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg>',
	);

	return sprintf(
		'<div style="text-align:center"><div class="aurelines-icon-circle aurelines-icon-circle--%s">%s</div></div>',
		esc_attr( $icon ),
		$svgs[ $icon ]
	);
}
