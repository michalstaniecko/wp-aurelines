<?php
/**
 * Aurelines Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register block pattern category.
 */
function aurelines_register_pattern_categories() {
	register_block_pattern_category( 'aurelines', array(
		'label' => __( 'Aurelines', 'aurelines' ),
	) );
}
add_action( 'init', 'aurelines_register_pattern_categories' );

/**
 * Enqueue theme assets.
 */
function aurelines_enqueue_assets() {
	$theme_uri = get_template_directory_uri();
	$theme_dir = get_template_directory();

	wp_enqueue_style(
		'aurelines-google-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'aurelines-custom',
		$theme_uri . '/assets/css/custom.css',
		array( 'aurelines-google-fonts' ),
		filemtime( $theme_dir . '/assets/css/custom.css' )
	);

	wp_enqueue_script(
		'aurelines-smooth-scroll',
		$theme_uri . '/assets/js/smooth-scroll.js',
		array(),
		filemtime( $theme_dir . '/assets/js/smooth-scroll.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'aurelines_enqueue_assets' );

/**
 * Handle contact form submission.
 */
function aurelines_handle_contact_form() {
	if ( ! isset( $_POST['aurelines_contact_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['aurelines_contact_nonce'], 'aurelines_contact' ) ) {
		wp_die( 'Błąd bezpieczeństwa.' );
	}

	$name    = sanitize_text_field( $_POST['contact_name'] ?? '' );
	$email   = sanitize_email( $_POST['contact_email'] ?? '' );
	$message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		set_transient( 'aurelines_contact_error', 'Wypełnij wszystkie pola.', 30 );
		wp_safe_redirect( wp_get_referer() . '#kontakt' );
		exit;
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf( 'Wiadomość ze strony Aurelines od %s', $name );
	$body    = sprintf( "Imię: %s\nEmail: %s\n\nWiadomość:\n%s", $name, $email, $message );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		set_transient( 'aurelines_contact_success', 'Dziękujemy! Wiadomość została wysłana.', 30 );
	} else {
		set_transient( 'aurelines_contact_error', 'Nie udało się wysłać wiadomości. Spróbuj ponownie.', 30 );
	}

	wp_safe_redirect( wp_get_referer() . '#kontakt' );
	exit;
}
add_action( 'admin_post_aurelines_contact', 'aurelines_handle_contact_form' );
add_action( 'admin_post_nopriv_aurelines_contact', 'aurelines_handle_contact_form' );
