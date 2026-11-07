<?php
/**
 * Scripts and styles.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end assets.
 */
function anishop_scripts() {
	wp_enqueue_style( 'anishop-vazirmatn', 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css', array(), '33.003' );
	wp_enqueue_style( 'anishop-style', get_stylesheet_uri(), array( 'anishop-vazirmatn' ), ANISHOP_VERSION );

	if ( anishop_is_woocommerce() ) {
		wp_enqueue_style( 'anishop-woo', ANISHOP_URI . '/assets/css/woocommerce.css', array( 'anishop-style' ), ANISHOP_VERSION );
	}

	wp_enqueue_script( 'anishop-main', ANISHOP_URI . '/assets/js/main.js', array(), ANISHOP_VERSION, true );
	wp_script_add_data( 'anishop-main', 'defer', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'anishop_scripts' );

/**
 * Preconnect for the font CDN.
 *
 * @param array  $urls URLs.
 * @param string $relation_type Relation type.
 * @return array
 */
function anishop_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://cdn.jsdelivr.net',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'anishop_resource_hints', 10, 2 );

/**
 * Editor styles.
 */
function anishop_editor_assets() {
	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'admin_init', 'anishop_editor_assets' );

/**
 * Make the header cart badge live-update on AJAX add-to-cart.
 *
 * @param array $fragments AJAX fragments.
 * @return array
 */
function anishop_cart_count_fragment( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	$fragments['span[data-cart-count]'] = '<span class="cart-count" data-cart-count>' . esc_html( anishop_fa_digits( $count ) ) . '</span>';

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'anishop_cart_count_fragment' );
