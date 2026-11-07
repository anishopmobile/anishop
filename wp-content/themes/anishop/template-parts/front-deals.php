<?php
/**
 * Front page: amazing deals (on-sale products) with countdown.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! anishop_is_woocommerce() ) {
	return;
}

$anishop_deals = wc_get_products( array(
	'status'   => 'publish',
	'limit'    => 10,
	'orderby'  => 'date',
	'order'    => 'DESC',
	'include'  => wc_get_product_ids_on_sale(),
) );

if ( empty( $anishop_deals ) ) {
	return;
}

$anishop_deals_title = get_theme_mod( 'anishop_deals_title', 'پیشنهاد شگفت‌انگیز' );

// Countdown target: end of today (site timezone).
$anishop_end = strtotime( 'tomorrow midnight' ) - (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
?>
<section class="deals-section" id="home-deals">
	<div class="container">
		<div class="deals-box">

			<div class="deals-head">
				<div class="deals-head-title">
					<?php anishop_icon_e( 'fire', 26 ); ?>
					<h2><?php echo esc_html( $anishop_deals_title ); ?></h2>
				</div>
				<div class="deals-countdown" data-countdown data-countdown-end="<?php echo esc_attr( $anishop_end ); ?>">
					<span class="cd-box" data-cd="hours">۰۰</span>
					<span class="cd-sep">:</span>
					<span class="cd-box" data-cd="minutes">۰۰</span>
					<span class="cd-sep">:</span>
					<span class="cd-box" data-cd="seconds">۰۰</span>
				</div>
				<a class="deals-view-all" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<?php esc_html_e( 'مشاهده همه', 'anishop' ); ?>
					<?php anishop_icon_e( 'chevron-l', 16 ); ?>
				</a>
			</div>

			<div class="deals-track" data-carousel>
				<button class="carousel-arrow prev" data-carousel-prev aria-label="<?php esc_attr_e( 'قبلی', 'anishop' ); ?>"><?php anishop_icon_e( 'chevron', 18 ); ?></button>

				<div class="deals-items" data-carousel-track>
					<?php foreach ( $anishop_deals as $anishop_deal_product ) : ?>
						<?php
						global $product;
						$product = $anishop_deal_product; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
						?>
						<div class="deals-item"><?php anishop_product_card( $product ); ?></div>
					<?php endforeach; ?>
				</div>

				<button class="carousel-arrow next" data-carousel-next aria-label="<?php esc_attr_e( 'بعدی', 'anishop' ); ?>"><?php anishop_icon_e( 'chevron-l', 18 ); ?></button>
			</div>

		</div>
	</div>
</section>
