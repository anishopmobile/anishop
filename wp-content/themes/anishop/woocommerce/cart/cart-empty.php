<?php
/**
 * Empty cart.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="empty-state">
	<?php anishop_icon_e( 'cart', 48 ); ?>
	<p><?php esc_html_e( 'سبد خرید شما خالی است.', 'anishop' ); ?></p>
	<a class="btn btn-primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'anishop' ); ?></a>
</div>
