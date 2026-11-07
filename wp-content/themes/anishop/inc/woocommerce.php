<?php
/**
 * WooCommerce tweaks: columns per row, sale flash, defaults.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Products per row.
 *
 * @return int
 */
function anishop_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'anishop_loop_columns' );

/**
 * Products per page.
 *
 * @return int
 */
function anishop_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'anishop_products_per_page', 20 );

/**
 * Related products count.
 *
 * @return int
 */
function anishop_related_products_count() {
	return 4;
}
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

/**
 * Cross-sells count in cart.
 */
add_filter( 'woocommerce_cross_sells_total', function () {
	return 4;
} );

/**
 * Default catalog ordering: newest first feels right for phones.
 */
add_filter( 'woocommerce_default_catalog_orderby', function () {
	return 'date';
} );

/**
 * Replace the default "Sale!" badge with a Persian-friendly one.
 *
 * @param string $html Badge HTML.
 * @param string $post Post object (unused).
 * @param string $product Product object.
 * @return string
 */
function anishop_sale_flash( $html, $post, $product ) {
	unset( $post );

	$label = __( 'تخفیف', 'anishop' );

	if ( $product && $product->is_type( 'variable' ) ) {
		$percent = anishop_max_variation_discount_percent( $product );
	} else {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		$percent = ( $regular > 0 && $sale > 0 && $sale < $regular )
			? round( ( ( $regular - $sale ) / $regular ) * 100 )
			: 0;
	}

	if ( $percent > 0 ) {
		$label = anishop_fa_digits( $percent ) . '٪';
	}

	return '<span class="onsale anishop-badge-sale">' . esc_html( $label ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'anishop_sale_flash', 10, 3 );

/**
 * Highest discount percentage among variations.
 *
 * @param WC_Product_Variable $product Variable product.
 * @return int
 */
function anishop_max_variation_discount_percent( $product ) {
	$max = 0;

	foreach ( $product->get_children() as $child_id ) {
		$variation = wc_get_product( $child_id );
		if ( ! $variation ) {
			continue;
		}
		$regular = (float) $variation->get_regular_price();
		$sale    = (float) $variation->get_sale_price();
		if ( $regular > 0 && $sale > 0 && $sale < $regular ) {
			$max = max( $max, (int) round( ( ( $regular - $sale ) / $regular ) * 100 ) );
		}
	}

	return $max;
}

/**
 * Mark the "new" badge window (days after publish).
 */
function anishop_is_new_product( $product ) {
	$days = (int) apply_filters( 'anishop_new_badge_days', 14 );
	if ( $days <= 0 ) {
		return false;
	}
	$created = $product->get_date_created();
	if ( ! $created ) {
		return false;
	}
	$diff = ( time() - $created->getTimestamp() ) / DAY_IN_SECONDS;
	return $diff <= $days;
}

/**
 * Move the result count + ordering into a neat toolbar.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 25 );

/**
 * Open the catalog toolbar before the result count.
 */
function anishop_toolbar_start() {
	echo '<div class="shop-toolbar">';
}
add_action( 'woocommerce_before_shop_loop', 'anishop_toolbar_start', 24 );

/**
 * Close the catalog toolbar after the ordering select.
 */
function anishop_toolbar_end() {
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'anishop_toolbar_end', 31 );

/**
 * Mini-cart drawer content for the header.
 *
 * @param array $args Template args.
 * @return string
 */
function anishop_mini_cart_content( $args = array() ) {
	ob_start();
	wc_get_template( 'cart/mini-cart.php', $args );
	return ob_get_clean();
}

/**
 * Expose the mini-cart drawer as an AJAX fragment so it stays in sync
 * whenever an item is added/removed or the cart refreshes.
 *
 * @param array $fragments AJAX fragments.
 * @return array
 */
function anishop_mini_cart_fragment( $fragments ) {
	$fragments['div.anishop-mini-cart-content'] = '<div class="anishop-mini-cart-content" data-mini-cart-body>'
		. anishop_mini_cart_content( array( 'list_class' => 'mini-cart-list' ) )
		. '</div>';

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'anishop_mini_cart_fragment', 20 );

/**
 * Wrap catalog orderby in a styled select automatically (CSS only).
 */

/**
 * Cross-sells belong below the cart grid, not inside the totals sidebar.
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 5 );
