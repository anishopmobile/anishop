<?php
/**
 * Template glue: part wrapper + product card.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Wrapper around get_template_part for template-parts/.
 *
 * @param string $name Part name.
 * @param array  $args Optional args forwarded to the part.
 */
function anishop_get_template_part( $name, $args = array() ) {
	get_template_part( 'template-parts/' . $name, null, $args );
}

/**
 * Render a product card.
 *
 * @param WC_Product $product Product object.
 */
function anishop_product_card( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$anishop_id      = $product->get_id();
	$anishop_link    = get_permalink( $anishop_id );
	$anishop_name    = $product->get_name();
	$anishop_img     = $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) );
	$anishop_is_new  = anishop_is_new_product( $product );
	$anishop_rating  = (float) $product->get_average_rating();
	?>
	<div class="product-card">
		<div class="product-card-media">
			<a href="<?php echo esc_url( $anishop_link ); ?>">
				<?php echo $anishop_img; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</a>
			<?php if ( $product->is_on_sale() ) : ?>
				<?php woocommerce_show_product_loop_sale_flash(); ?>
			<?php elseif ( $anishop_is_new ) : ?>
				<span class="anishop-badge-new"><?php esc_html_e( 'جدید', 'anishop' ); ?></span>
			<?php endif; ?>
			<div class="product-card-actions">
				<?php
				if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
					woocommerce_template_loop_add_to_cart( array( 'class' => 'product-card-cart' ) );
				}
				?>
				<a class="product-card-wish" href="<?php echo esc_url( $anishop_link ); ?>" aria-label="<?php esc_attr_e( 'علاقه‌مندی', 'anishop' ); ?>">
					<?php anishop_icon_e( 'heart', 18 ); ?>
				</a>
			</div>
		</div>
		<div class="product-card-body">
			<h3 class="woocommerce-loop-product__title product-card-title">
				<a href="<?php echo esc_url( $anishop_link ); ?>"><?php echo esc_html( $anishop_name ); ?></a>
			</h3>
			<?php if ( $anishop_rating > 0 ) : ?>
				<span class="product-card-rating">
					<?php anishop_icon_e( 'star', 14 ); ?>
					<?php echo esc_html( anishop_fa_digits( number_format( $anishop_rating, 1 ) ) ); ?>
				</span>
			<?php endif; ?>
			<div class="product-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		</div>
	</div>
	<?php
}

/**
 * Extra widget areas used by header/footer.
 */
function anishop_extra_widgets() {
	register_sidebar( array(
		'name'          => __( 'نوار بالای سایت', 'anishop' ),
		'id'            => 'topbar',
		'before_widget' => '<div id="%1$s" class="topbar-widget %2$s">',
		'after_widget'  => '</div>',
	) );

	register_sidebar( array(
		'name'          => __( 'نوار تبلیغاتی بالای فوتر', 'anishop' ),
		'id'            => 'footer-cta',
		'before_widget' => '<div id="%1$s" class="footer-cta-widget %2$s">',
		'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'anishop_extra_widgets', 20 );

/**
 * Customizer: hero slide images + side-card links.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function anishop_customize_hero( $wp_customize ) {
	for ( $anishop_i = 1; $anishop_i <= 3; $anishop_i++ ) {
		$wp_customize->add_setting( "anishop_hero{$anishop_i}_image", array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "anishop_hero{$anishop_i}_image", array(
			'label'   => sprintf( __( 'تصویر اسلاید %d', 'anishop' ), $anishop_i ),
			'section' => 'anishop_home',
		) ) );
	}

	for ( $anishop_i = 1; $anishop_i <= 3; $anishop_i++ ) {
		$wp_customize->add_setting( "anishop_hero_side{$anishop_i}_url", array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "anishop_hero_side{$anishop_i}_url", array(
			'label'   => sprintf( __( 'لینک کارت کنار اسلایدر %d', 'anishop' ), $anishop_i ),
			'section' => 'anishop_home',
			'type'    => 'url',
		) );
	}
}
add_action( 'customize_register', 'anishop_customize_hero', 20 );
