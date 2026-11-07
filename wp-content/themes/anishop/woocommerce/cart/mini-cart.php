<?php
/**
 * Mini-cart (used inside the header drawer).
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package Anishop
 * @version 9.4.0
 *
 * @var WC_Cart $cart Cart object.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart || WC()->cart->is_empty() ) : ?>

	<div class="mini-cart-empty">
		<?php anishop_icon_e( 'cart', 40 ); ?>
		<p><?php esc_html_e( 'سبد خرید شما خالی است.', 'anishop' ); ?></p>
		<a class="btn btn-primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'anishop' ); ?></a>
	</div>

<?php else : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( isset( $args['list_class'] ) ? $args['list_class'] : '' ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $anishop_mc_key => $anishop_mc_item ) {
			$anishop_mc_product = apply_filters( 'woocommerce_cart_item_product', $anishop_mc_item['data'], $anishop_mc_item, $anishop_mc_key );

			if ( ! $anishop_mc_product || ! $anishop_mc_product->exists() || $anishop_mc_item['quantity'] <= 0 ) {
				continue;
			}

			$anishop_mc_name      = apply_filters( 'woocommerce_cart_item_name', $anishop_mc_product->get_name(), $anishop_mc_item, $anishop_mc_key );
			$anishop_mc_permalink = apply_filters( 'woocommerce_cart_item_permalink', $anishop_mc_product->is_visible() ? $anishop_mc_product->get_permalink( $anishop_mc_item ) : '', $anishop_mc_item, $anishop_mc_key );
			$anishop_mc_thumb     = apply_filters( 'woocommerce_cart_item_thumbnail', $anishop_mc_product->get_image(), $anishop_mc_item, $anishop_mc_key );
			$anishop_mc_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $anishop_mc_product ), $anishop_mc_item, $anishop_mc_key );
			?>
			<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $anishop_mc_item, $anishop_mc_key ) ); ?>">

				<?php
				echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'woocommerce_cart_item_remove_link',
					sprintf(
						'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
						esc_url( wc_get_cart_remove_url( $anishop_mc_key ) ),
						esc_attr__( 'حذف این محصول', 'anishop' ),
						esc_attr( $anishop_mc_product->get_id() ),
						esc_attr( $anishop_mc_key ),
						esc_attr( $anishop_mc_product->get_sku() )
					),
					$anishop_mc_key
				);
				?>

				<span class="mini-cart-thumb">
					<?php
					if ( $anishop_mc_permalink ) {
						printf( '<a href="%s">%s</a>', esc_url( $anishop_mc_permalink ), $anishop_mc_thumb ); // phpcs:ignore WordPress.Security.EscapeOutput
					} else {
						echo $anishop_mc_thumb; // phpcs:ignore WordPress.Security.EscapeOutput
					}
					?>
				</span>

				<span class="mini-cart-info">
					<span class="mini-cart-name">
						<?php
						if ( $anishop_mc_permalink ) {
							printf( '<a href="%s">%s</a>', esc_url( $anishop_mc_permalink ), wp_kses_post( $anishop_mc_name ) );
						} else {
							echo wp_kses_post( $anishop_mc_name );
						}
						?>
					</span>

					<?php echo wc_get_formatted_cart_item_data( $anishop_mc_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

					<span class="mini-cart-row">
						<?php echo wp_kses_post( $anishop_mc_price ); ?>
						<span class="mini-cart-qty"><?php echo esc_html( anishop_fa_digits( $anishop_mc_item['quantity'] ) ); ?> ×</span>
					</span>
				</span>
			</li>
			<?php
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_total' ); ?>

	<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
