<?php
/**
 * Checkout form wrapper.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout anishop-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="checkout-fields" id="customer_details">
			<div class="billing-fields"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
			<div class="shipping-fields"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

	<h3 id="order_review_heading"><?php esc_html_e( 'سفارش شما', 'anishop' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>
