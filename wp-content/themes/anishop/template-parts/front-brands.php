<?php
/**
 * Front page: brands strip.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! anishop_is_woocommerce() ) {
	return;
}

// Prefer whichever brand taxonomy actually has terms.
$anishop_brands = array();

foreach ( array( 'product_brand', 'pa_brand' ) as $anishop_brand_tax ) {
	if ( ! taxonomy_exists( $anishop_brand_tax ) ) {
		continue;
	}

	$anishop_brands = get_terms( array(
		'taxonomy'   => $anishop_brand_tax,
		'hide_empty' => false,
		'number'     => 10,
	) );

	if ( ! is_wp_error( $anishop_brands ) && ! empty( $anishop_brands ) ) {
		break;
	}
}

if ( empty( $anishop_brands ) || is_wp_error( $anishop_brands ) ) {
	return;
}

$anishop_brands_title = get_theme_mod( 'anishop_brands_title', 'برندهای محبوب' );
?>
<section class="home-section container" id="home-brands">
	<header class="section-head">
		<div class="section-head-title">
			<?php anishop_icon_e( 'shield', 22 ); ?>
			<h2 class="section-title"><?php echo esc_html( $anishop_brands_title ); ?></h2>
		</div>
		<span class="section-line" aria-hidden="true"></span>
	</header>

	<div class="brands-grid">
		<?php foreach ( $anishop_brands as $anishop_brand ) : ?>
			<a class="brand-card" href="<?php echo esc_url( get_term_link( $anishop_brand ) ); ?>">
				<span class="brand-name"><?php echo esc_html( $anishop_brand->name ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
