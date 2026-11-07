<?php
/**
 * Front page: product categories.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! anishop_is_woocommerce() ) {
	return;
}

$anishop_terms = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'number'     => 8,
	'parent'     => 0,
) );

if ( is_wp_error( $anishop_terms ) || empty( $anishop_terms ) ) {
	return;
}
?>
<section class="home-section container" id="home-categories">
	<header class="section-head">
		<h2 class="section-title"><?php esc_html_e( 'دسته‌بندی‌های فروشگاه', 'anishop' ); ?></h2>
		<span class="section-line" aria-hidden="true"></span>
	</header>

	<div class="category-grid">
		<?php foreach ( $anishop_terms as $anishop_term ) : ?>
			<?php
			$anishop_thumb_id = get_term_meta( $anishop_term->term_id, 'thumbnail_id', true );
			$anishop_img      = $anishop_thumb_id ? wp_get_attachment_image_url( $anishop_thumb_id, 'anishop-cat' ) : '';
			$anishop_icon     = anishop_term_icon( $anishop_term->term_id );
			?>
			<a class="category-card" href="<?php echo esc_url( get_term_link( $anishop_term ) ); ?>">
				<span class="category-media">
					<?php if ( $anishop_img ) : ?>
						<img src="<?php echo esc_url( $anishop_img ); ?>" alt="<?php echo esc_attr( $anishop_term->name ); ?>" loading="lazy" width="72" height="72">
					<?php else : ?>
						<?php anishop_icon_e( $anishop_icon, 30 ); ?>
					<?php endif; ?>
				</span>
				<span class="category-name"><?php echo esc_html( $anishop_term->name ); ?></span>
				<span class="category-count"><?php echo esc_html( anishop_fa_digits( $anishop_term->count ) ); ?> کالا</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
