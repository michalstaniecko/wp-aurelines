<?php
/**
 * Register all custom Gutenberg blocks.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$aurelines_blocks = array(
	'badge',
	'contact-info',
	'icon-circle',
);

foreach ( $aurelines_blocks as $block ) {
	require_once __DIR__ . '/' . $block . '/index.php';
}
