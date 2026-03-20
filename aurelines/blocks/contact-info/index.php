<?php
/**
 * Aurelines Contact Info Block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the contact-info block.
 */
function aurelines_contact_info_register() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_register_script(
		'aurelines-contact-info-editor',
		$theme_uri . '/blocks/contact-info/editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
		filemtime( $theme_dir . '/blocks/contact-info/editor.js' ),
		true
	);

	wp_register_style(
		'aurelines-contact-info-style',
		$theme_uri . '/blocks/contact-info/style.css',
		array(),
		filemtime( $theme_dir . '/blocks/contact-info/style.css' )
	);

	register_block_type( 'aurelines/contact-info', array(
		'editor_script'   => 'aurelines-contact-info-editor',
		'style'           => 'aurelines-contact-info-style',
		'render_callback' => 'aurelines_contact_info_render',
		'attributes'      => array(
			'items' => array(
				'type'    => 'array',
				'default' => array(
					array( 'icon' => 'phone', 'text' => '+48 123 456 789' ),
					array( 'icon' => 'email', 'text' => 'kontakt@aurelines.pl' ),
					array( 'icon' => 'location', 'text' => 'ul. Akrobatyczna 12, 00-001 Warszawa' ),
				),
			),
		),
	) );
}
add_action( 'init', 'aurelines_contact_info_register' );

/**
 * Render the contact-info block on the frontend.
 */
function aurelines_contact_info_render( $attributes ) {
	$icons = array(
		'phone'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'email'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
		'location' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
	);

	$items = $attributes['items'];
	$output = '<div class="aurelines-contact-info">';

	foreach ( $items as $item ) {
		$icon_key = isset( $item['icon'] ) && isset( $icons[ $item['icon'] ] ) ? $item['icon'] : 'phone';
		$text     = isset( $item['text'] ) ? esc_html( $item['text'] ) : '';

		$output .= sprintf(
			'<div class="aurelines-contact-row"><span class="aurelines-contact-icon">%s</span><span>%s</span></div>',
			$icons[ $icon_key ],
			$text
		);
	}

	$output .= '</div>';

	return $output;
}
