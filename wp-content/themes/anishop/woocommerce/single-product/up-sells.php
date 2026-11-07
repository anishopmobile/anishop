<?php
/**
 * Upsells.
 *
 * Expects $upsells, $args.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $upsells ) ) {
	return;
}

$anishop_upsell_heading = ! empty( $args['heading'] ) ? $args['heading'] : __( 'شاید این‌ها را هم بپسندید', 'anishop' );
?>
<section class="upsells home-section container">
	<header class="section-head">
		<div class="section-head-title">
			<?php anishop_icon_e( 'gift', 22 ); ?>
			<h2 class="section-title"><?php echo esc_html( $anishop_upsell_heading ); ?></h2>
		</div>
		<span class="section-line" aria-hidden="true"></span>
	</header>

	<div class="product-grid">
		<?php foreach ( $upsells as $anishop_upsell_product ) : ?>
			<?php
			$post_object = get_post( $anishop_upsell_product->get_id() );
			setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			wc_get_template_part( 'content', 'product' );
			?>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
