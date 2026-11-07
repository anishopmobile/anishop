<?php
/**
 * Related products.
 *
 * Expects $related_products, $args.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

$anishop_related_heading = ! empty( $args['heading'] ) ? $args['heading'] : __( 'محصولات مرتبط', 'anishop' );

if ( empty( $related_products ) ) {
	return;
}
?>
<section class="related-products home-section container">
	<header class="section-head">
		<div class="section-head-title">
			<?php anishop_icon_e( 'grid', 22 ); ?>
			<h2 class="section-title"><?php echo esc_html( $anishop_related_heading ); ?></h2>
		</div>
		<span class="section-line" aria-hidden="true"></span>
	</header>

	<div class="product-grid">
		<?php foreach ( $related_products as $anishop_related_product ) : ?>
			<?php
			$post_object = get_post( $anishop_related_product->get_id() );
			setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			wc_get_template_part( 'content', 'product' );
			?>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
