<?php
/**
 * My Account wrapper: vertical navigation + content.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="account-wrap">

	<aside class="account-nav-col">
		<nav class="account-nav" aria-label="<?php esc_attr_e( 'منوی حساب کاربری', 'anishop' ); ?>">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		</nav>
	</aside>

	<div class="account-content-col">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>

</div>
