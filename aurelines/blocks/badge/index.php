<?php
/**
 * Aurelines Badge Block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the badge block.
 */
function aurelines_badge_register() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_register_script(
		'aurelines-badge-editor',
		$theme_uri . '/blocks/badge/editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
		filemtime( $theme_dir . '/blocks/badge/editor.js' ),
		true
	);

	wp_register_style(
		'aurelines-badge-editor',
		$theme_uri . '/blocks/badge/editor.css',
		array(),
		filemtime( $theme_dir . '/blocks/badge/editor.css' )
	);

	register_block_type( 'aurelines/badge', array(
		'editor_script'   => 'aurelines-badge-editor',
		'editor_style'    => 'aurelines-badge-editor',
		'render_callback' => 'aurelines_badge_render',
		'attributes'      => array(
			'text'    => array(
				'type'    => 'string',
				'default' => 'Badge',
			),
			'variant' => array(
				'type'    => 'string',
				'default' => 'section',
			),
		),
	) );
}
add_action( 'init', 'aurelines_badge_register' );

/**
 * Render the badge block on the frontend.
 */
function aurelines_badge_render( $attributes ) {
	$text    = esc_html( $attributes['text'] );
	$variant = in_array( $attributes['variant'], array( 'hero', 'section' ), true )
		? $attributes['variant']
		: 'section';

	return sprintf(
		'<div class="aurelines-badge aurelines-badge--%s aurelines-reveal">%s</div>',
		esc_attr( $variant ),
		$text
	);
}
