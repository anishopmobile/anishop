<?php
/**
 * Review order table (checkout sidebar).
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

$order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'ثبت و پرداخت سفارش', 'anishop' ) );
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr><th><?php esc_html_e( 'محصولات', 'anishop' ); ?></th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php
		foreach ( WC()->cart->get_cart() as $anishop_ro_key => $anishop_ro_item ) {
			$anishop_ro_product = apply_filters( 'woocommerce_cart_item_product', $anishop_ro_item['data'], $anishop_ro_item, $anishop_ro_key );
			if ( ! $anishop_ro_product || ! $anishop_ro_product->exists() || $anishop_ro_item['quantity'] <= 0 ) {
				continue;
			}
			?>
			<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $anishop_ro_item, $anishop_ro_key ) ); ?>">
				<td class="ro-name">
					<span class="ro-qty"><?php echo esc_html( anishop_fa_digits( $anishop_ro_item['quantity'] ) ); ?> ×</span>
					<?php echo wp_kses_post( $anishop_ro_product->get_name() ); ?>
					<?php echo wc_get_formatted_cart_item_data( $anishop_ro_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</td>
				<td class="ro-total"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $anishop_ro_product, $anishop_ro_item['quantity'] ), $anishop_ro_item, $anishop_ro_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'جمع سبد', 'anishop' ); ?></th>
			<td><?php echo wc_cart_totals_subtotal_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
		</tr>
		<?php foreach ( WC()->cart->get_coupons() as $anishop_ro_coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( $anishop_ro_coupon->get_code() ); ?>">
				<th><?php esc_html_e( 'کد تخفیف', 'anishop' ); ?>: <?php echo esc_html( $anishop_ro_coupon->get_code() ); ?></th>
				<td><?php echo wc_cart_totals_coupon_html( $anishop_ro_coupon ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
			</tr>
		<?php endforeach; ?>
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		<?php endif; ?>
		<?php foreach ( WC()->cart->get_fees() as $anishop_ro_fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $anishop_ro_fee->name ); ?></th>
				<td><?php echo wc_cart_totals_fee_html( $anishop_ro_fee ); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
			</tr>
		<?php endforeach; ?>
		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<tr class="tax-row">
				<th><?php esc_html_e( 'مالیات', 'anishop' ); ?></th>
				<td><?php echo wc_cart_totals_taxes_total_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
			</tr>
		<?php endif; ?>
		<tr class="order-total">
			<th><?php esc_html_e( 'مبلغ قابل پرداخت', 'anishop' ); ?></th>
			<td><?php echo WC()->cart->get_total(); // phpcs:ignore WordPress.Security.EscapeOutput ?></td>
		</tr>
	</tfoot>
</table>

<div id="payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			foreach ( WC()->payment_gateways()->get_available_payment_gateways() as $anishop_ro_gateway ) {
				wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $anishop_ro_gateway ) );
			}
			?>
		</ul>
	<?php else : ?>
		<p class="woocommerce-notice woocommerce-notice--info"><?php esc_html_e( 'این سفارش نیاز به پرداخت آنلاین ندارد.', 'anishop' ); ?></p>
	<?php endif; ?>

	<div class="place-order">
		<noscript><?php esc_html_e( 'از آنجا که مرورگر شما جاوااسکریپت ندارد، باید دوباره روی دکمه پرداخت کلیک کنید.', 'anishop' ); ?></noscript>
		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
		<button type="submit" class="button alt btn btn-primary" name="woocommerce_checkout_place_order" value="<?php echo esc_attr( $order_button_text ); ?>"><?php echo esc_html( $order_button_text ); ?></button>
		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
		<p class="checkout-terms"><?php wc_get_template( 'checkout/terms.php' ); ?></p>
		<?php do_action( 'woocommerce_review_order_after_payment' ); ?>
	</div>
</div>
