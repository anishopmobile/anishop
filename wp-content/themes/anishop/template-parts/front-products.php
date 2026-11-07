<?php
/**
 * Front page: reusable product row.
 *
 * Expects $args = array( 'type' => bestselling|newest|featured, 'title' => string, 'limit' => int, 'icon' => string )
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! anishop_is_woocommerce() ) {
	return;
}

$anishop_args = wp_parse_args( $args ?? array(), array(
	'type'  => 'newest',
	'title' => '',
	'limit' => 8,
	'icon'  => 'star',
) );

$anishop_query_args = array(
	'status'  => 'publish',
	'limit'   => (int) $anishop_args['limit'],
	'orderby' => 'date',
	'order'   => 'DESC',
);

if ( 'bestselling' === $anishop_args['type'] ) {
	$anishop_query_args['orderby'] = 'meta_value_num';
	$anishop_query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery
	$anishop_query_args['order']    = 'DESC';
} elseif ( 'featured' === $anishop_args['type'] ) {
	$anishop_query_args['include'] = wc_get_featured_product_ids();
}

$anishop_products = wc_get_products( $anishop_query_args );

if ( empty( $anishop_products ) ) {
	return;
}

$anishop_links = array(
	'bestselling' => wc_get_page_permalink( 'shop' ),
	'newest'      => wc_get_page_permalink( 'shop' ),
	'featured'    => wc_get_page_permalink( 'shop' ),
);
?>
<section class="home-section container" id="home-<?php echo esc_attr( $anishop_args['type'] ); ?>">
	<header class="section-head">
		<div class="section-head-title">
			<?php anishop_icon_e( $anishop_args['icon'], 22 ); ?>
			<h2 class="section-title"><?php echo esc_html( $anishop_args['title'] ); ?></h2>
		</div>
		<span class="section-line" aria-hidden="true"></span>
		<a class="section-link" href="<?php echo esc_url( $anishop_links[ $anishop_args['type'] ] ?? wc_get_page_permalink( 'shop' ) ); ?>">
			<?php esc_html_e( 'مشاهده همه', 'anishop' ); ?>
			<?php anishop_icon_e( 'chevron-l', 16 ); ?>
		</a>
	</header>

	<div class="product-row" data-carousel>
		<button class="carousel-arrow prev" data-carousel-prev aria-label="<?php esc_attr_e( 'قبلی', 'anishop' ); ?>"><?php anishop_icon_e( 'chevron', 18 ); ?></button>
		<div class="product-row-track" data-carousel-track>
			<?php foreach ( $anishop_products as $anishop_row_product ) : ?>
				<?php anishop_product_card( $anishop_row_product ); ?>
			<?php endforeach; ?>
		</div>
		<button class="carousel-arrow next" data-carousel-next aria-label="<?php esc_attr_e( 'بعدی', 'anishop' ); ?>"><?php anishop_icon_e( 'chevron-l', 18 ); ?></button>
	</div>
</section>
