<?php
/**
 * Loop product card.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

anishop_product_card( $product );
