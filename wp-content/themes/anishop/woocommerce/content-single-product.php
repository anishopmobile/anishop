<?php
/**
 * Single product template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Notices (fires once, before the layout).
 */
do_action( 'woocommerce_before_single_product' );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'anishop-single', $product ); ?>>

	<div class="single-grid">

		<div class="single-gallery">
			<?php
			/**
			 * Gallery + data (zoom/lightbox/slider via theme supports).
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="single-summary summary entry-content">
			<?php
			/**
			 * Default core hooks render in order:
			 * title(5), rating(10), price(10), excerpt(20),
			 * add_to_cart(30), meta(40).
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>

		<div class="single-tabs-wrap">
			<?php
			woocommerce_output_product_data_tabs();
			woocommerce_upsell_display();
			do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>

	</div>

	<meta itemprop="url" content="<?php the_permalink(); ?>">

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
