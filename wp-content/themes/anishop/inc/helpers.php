<?php
/**
 * Small template helpers.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is WooCommerce active?
 *
 * @return bool
 */
function anishop_is_woocommerce() {
	return class_exists( 'WooCommerce' );
}

/**
 * Convert Latin digits to Persian digits.
 *
 * @param string|int $number Input number.
 * @return string
 */
function anishop_fa_digits( $number ) {
	$en = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$fa = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $en, $fa, (string) $number );
}

/**
 * Thousand separator with Persian digits: 12500000 -> ۱۲٬۵۰۰٬۰۰۰
 *
 * @param string|int $number Input number.
 * @return string
 */
function anishop_price_digits( $number ) {
	$formatted = number_format( (float) $number, 0, '.', '٬' );
	return anishop_fa_digits( $formatted );
}

/**
 * Inline SVG icon by name.
 *
 * @param string $name Icon key.
 * @param int    $size Width/height in px.
 * @return string SVG markup.
 */
function anishop_icon( $name, $size = 22 ) {
	$attrs = sprintf(
		'width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"',
		(int) $size,
		(int) $size
	);

	$paths = array(
		'phone'     => '<rect x="7" y="2.5" width="10" height="19" rx="2.5"/><line x1="10.5" y1="18.5" x2="13.5" y2="18.5"/>',
		'headset'   => '<path d="M4 13a8 8 0 0 1 16 0"/><rect x="2.5" y="13" width="4" height="6.5" rx="1.8"/><rect x="17.5" y="13" width="4" height="6.5" rx="1.8"/><path d="M19.5 19.5c0 1.7-1.8 2.6-3.9 2.6"/>',
		'truck'     => '<rect x="1.5" y="5.5" width="13" height="10" rx="1.5"/><path d="M14.5 9h4.2l3.3 3.5v3h-7.5z"/><circle cx="6" cy="17.8" r="1.9"/><circle cx="17.8" cy="17.8" r="1.9"/>',
		'shield'    => '<path d="M12 2.8l7.5 2.8v6.1c0 4.6-3.2 7.9-7.5 9.5-4.3-1.6-7.5-4.9-7.5-9.5V5.6z"/><path d="M8.8 12.2l2.3 2.3 4.2-4.6"/>',
		'wallet'    => '<rect x="2.5" y="6" width="19" height="13" rx="2.5"/><path d="M2.5 10h19"/>',
		'cart'      => '<circle cx="9.5" cy="20" r="1.6"/><circle cx="18" cy="20" r="1.6"/><path d="M2.5 3.5h2.6l2.5 11.6h11.1l2.3-8.4H6"/>',
		'user'      => '<circle cx="12" cy="8" r="3.8"/><path d="M4.5 20.5c1.4-3.6 4.1-5.2 7.5-5.2s6.1 1.6 7.5 5.2"/>',
		'search'    => '<circle cx="11" cy="11" r="6.5"/><line x1="16" y1="16" x2="21" y2="21"/>',
		'heart'     => '<path d="M12 20.5S3.5 15.4 3.5 9.6C3.5 6.9 5.6 5 8 5c1.7 0 3.2.9 4 2.3C12.8 5.9 14.3 5 16 5c2.4 0 4.5 1.9 4.5 4.6 0 5.8-8.5 10.9-8.5 10.9z"/>',
		'compare'   => '<path d="M9 3.5v17M15 3.5v17M9 5.5L4 8v10l5-2.5M15 5.5L20 8v10l-5-2.5"/>',
		'chevron'   => '<path d="M14.5 5.5L8 12l6.5 6.5"/>',
		'chevron-l' => '<path d="M9.5 5.5L16 12l-6.5 6.5"/>',
		'down'      => '<path d="M5.5 9.5L12 16l6.5-6.5"/>',
		'menu'      => '<line x1="4" y1="6.5" x2="20" y2="6.5"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17.5" x2="20" y2="17.5"/>',
		'close'     => '<line x1="5.5" y1="5.5" x2="18.5" y2="18.5"/><line x1="18.5" y1="5.5" x2="5.5" y2="18.5"/>',
		'fire'      => '<path d="M12 21.5c-3.9 0-6.5-2.6-6.5-6.2 0-2.6 1.6-4.6 3-6.1.4 1.1 1.2 2 2.2 2.4C10.4 8.6 11 5.2 14 2.5c-.2 2.2.7 3.5 1.9 4.9 1.3 1.5 2.6 3.2 2.6 5.9 0 3.6-2.6 6.2-6.5 6.2z"/>',
		'grid'      => '<rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/>',
		'bolt'      => '<path d="M13 2.5L5 13.5h5l-1 8 8-11h-5z"/>',
		'watch'     => '<circle cx="12" cy="12" r="5.5"/><path d="M9 6.8L8.5 2.5h7L15 6.8M9 17.2l-.5 4.3h7l.5-4.3"/>',
		'tablet'    => '<rect x="4.5" y="2.5" width="15" height="19" rx="2.5"/><line x1="10" y1="18.5" x2="14" y2="18.5"/>',
		'audio'     => '<path d="M4 14v-3a8 8 0 0 1 16 0v3"/><rect x="2.5" y="13.5" width="4.5" height="7" rx="2"/><rect x="17" y="13.5" width="4.5" height="7" rx="2"/>',
		'gift'      => '<rect x="3.5" y="8" width="17" height="4" rx="1"/><path d="M5 12v8.5h14V12M12 8v12.5M12 8s-1-5.5-4.5-5.5C5.6 2.5 5 4 5 5s1 3 7 3zM12 8s1-5.5 4.5-5.5C18.4 2.5 19 4 19 5s-1 3-7 3z"/>',
		'location'  => '<path d="M12 21.5s-7-6-7-11a7 7 0 0 1 14 0c0 5-7 11-7 11z"/><circle cx="12" cy="10.2" r="2.6"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.2l3.4 2"/>',
		'star'      => '<path d="M12 3.2l2.7 5.6 6.1.8-4.5 4.2 1.1 6-5.4-3-5.4 3 1.1-6L3.2 9.6l6.1-.8z"/>',
		'trash'     => '<path d="M4 6.5h16M9.5 6.5V4h5v2.5M6.5 6.5l1 14h9l1-14"/>',
		'filter'    => '<path d="M4 6h16M7 12h10M10 18h4"/>',
		'check'     => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return '<svg class="anishop-icon anishop-icon-' . esc_attr( $name ) . '" ' . $attrs . '><path d="M0 0h24v24H0z" fill="none" stroke="none"/>' . $paths[ $name ] . '</svg>';
}

/**
 * Echo an icon.
 *
 * @param string $name Icon key.
 * @param int    $size Size.
 */
function anishop_icon_e( $name, $size = 22 ) {
	echo anishop_icon( $name, $size ); // phpcs:ignore WordPress.Security.EscapeOutput -- static internal SVG.
}

/**
 * Term meta helper: category icon slug stored as term meta `anishop_icon`.
 *
 * @param int $term_id Term ID.
 * @return string
 */
function anishop_term_icon( $term_id ) {
	$icon = get_term_meta( $term_id, 'anishop_icon', true );
	return $icon ? $icon : 'phone';
}

/**
 * Home page section order/enable, filterable.
 *
 * @return array
 */
function anishop_home_sections() {
	return apply_filters( 'anishop_home_sections', array(
		'features',
		'categories',
		'deals',
		'bestselling',
		'newest',
		'brands',
		'blog',
	) );
}
