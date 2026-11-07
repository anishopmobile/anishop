<?php
/**
 * Cart page: items first, sticky totals beside them.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="anishop-cart-grid">
	<div class="anishop-cart-main">
	<form class="woocommerce-cart-form anishop-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-thumbnail" colspan="2"><?php esc_html_e( 'محصول', 'anishop' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'قیمت', 'anishop' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'تعداد', 'anishop' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'جمع', 'anishop' ); ?></th>
				<th class="product-remove">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $anishop_cart_item_key => $anishop_cart_item ) {
				$anishop_cart_product = apply_filters( 'woocommerce_cart_item_product', $anishop_cart_item['data'], $anishop_cart_item, $anishop_cart_item_key );

				if ( ! $anishop_cart_product || ! $anishop_cart_product->exists() || $anishop_cart_item['quantity'] <= 0 ) {
					continue;
				}

				$anishop_product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $anishop_cart_product->is_visible() ? $anishop_cart_product->get_permalink( $anishop_cart_item ) : '', $anishop_cart_item, $anishop_cart_item_key );
				?>
				<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $anishop_cart_item, $anishop_cart_item_key ) ); ?>">

					<td class="product-thumbnail">
						<?php
						$anishop_thumb = apply_filters( 'woocommerce_cart_item_thumbnail', $anishop_cart_product->get_image(), $anishop_cart_item, $anishop_cart_item_key );
						if ( $anishop_product_permalink ) {
							printf( '<a href="%s">%s</a>', esc_url( $anishop_product_permalink ), $anishop_thumb ); // phpcs:ignore WordPress.Security.EscapeOutput
						} else {
							echo $anishop_thumb; // phpcs:ignore WordPress.Security.EscapeOutput
						}
						?>
					</td>

					<td class="product-name" data-title="<?php esc_attr_e( 'محصول', 'anishop' ); ?>">
						<?php
						if ( $anishop_product_permalink ) {
							printf( '<a href="%s">%s</a>', esc_url( $anishop_product_permalink ), wp_kses_post( $anishop_cart_product->get_name() ) );
						} else {
							echo wp_kses_post( $anishop_cart_product->get_name() );
						}
						do_action( 'woocommerce_after_cart_item_name', $anishop_cart_item, $anishop_cart_item_key );
						echo wc_get_formatted_cart_item_data( $anishop_cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>

					<td class="product-price" data-title="<?php esc_attr_e( 'قیمت', 'anishop' ); ?>">
						<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $anishop_cart_product ), $anishop_cart_item, $anishop_cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e( 'تعداد', 'anishop' ); ?>">
						<?php
						if ( $anishop_cart_product->is_sold_individually() ) {
							$anishop_qty = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', esc_attr( $anishop_cart_item_key ) );
						} else {
							$anishop_qty = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$anishop_cart_item_key}][qty]",
									'input_value'  => $anishop_cart_item['quantity'],
									'max_value'    => $anishop_cart_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $anishop_cart_product->get_name(),
								),
								$anishop_cart_product,
								false
							);
						}
						echo apply_filters( 'woocommerce_cart_item_quantity', $anishop_qty, $anishop_cart_item_key, $anishop_cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_attr_e( 'جمع', 'anishop' ); ?>">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $anishop_cart_product, $anishop_cart_item['quantity'] ), $anishop_cart_item, $anishop_cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</td>

					<td class="product-remove">
						<?php
						echo apply_filters(
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
								esc_url( wc_get_cart_remove_url( $anishop_cart_item_key ) ),
								esc_attr__( 'حذف', 'anishop' ),
								esc_attr( $anishop_cart_product->get_id() ),
								esc_attr( $anishop_cart_product->get_sku() ),
								anishop_icon( 'trash', 18 )
							),
							$anishop_cart_item_key
						); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>
				</tr>
				<?php
			}
			?>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	<div class="cart-actions">
		<button type="submit" class="btn btn-ghost" name="update_cart" value="<?php esc_attr_e( 'به‌روزرسانی سبد', 'anishop' ); ?>"><?php esc_html_e( 'به‌روزرسانی سبد', 'anishop' ); ?></button>
		<?php do_action( 'woocommerce_cart_actions' ); ?>
		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
	</div>
	</form>
	</div><!-- .anishop-cart-main -->

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<aside class="anishop-cart-totals cart-collaterals">
		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</aside>

</div><!-- .anishop-cart-grid -->

<?php do_action( 'woocommerce_after_cart' ); ?>
