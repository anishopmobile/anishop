<?php
/**
 * Footer template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
</main><!-- #main -->

<footer class="site-footer">
	<?php if ( is_active_sidebar( 'footer-cta' ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php dynamic_sidebar( 'footer-cta' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="footer-main">
		<div class="container footer-columns">

			<div class="footer-col footer-about">
				<div class="footer-logo">
					<span class="logo-mark"><?php anishop_icon_e( 'phone', 18 ); ?></span>
					<span class="logo-text">آنی‌<em>شاپ</em></span>
				</div>
				<p class="footer-about-text">
					<?php echo wp_kses_post( get_theme_mod( 'anishop_footer_about', 'آنی‌شاپ، فروشگاه اینترنتی موبایل و لوازم جانبی با ضمانت اصالت کالا، ارسال سریع و پشتیبانی واقعی.' ) ); ?>
				</p>
				<div class="footer-social">
					<?php if ( $anishop_instagram = get_theme_mod( 'anishop_instagram', 'https://instagram.com/anishop' ) ) : ?>
						<a href="<?php echo esc_url( $anishop_instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
							<?php anishop_icon_e( 'heart', 18 ); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="RSS">
						<?php anishop_icon_e( 'bolt', 18 ); ?>
					</a>
				</div>
			</div>

			<?php
			$anishop_footer_menus = array( 'footer1', 'footer2', 'footer3' );
			foreach ( $anishop_footer_menus as $anishop_index => $anishop_location ) :
				if ( ! has_nav_menu( $anishop_location ) ) {
					continue;
				}
				?>
				<div class="footer-col">
					<?php
					wp_nav_menu( array(
						'theme_location' => $anishop_location,
						'container'      => false,
						'menu_class'     => 'footer-menu',
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
					?>
				</div>
			<?php endforeach; ?>

			<div class="footer-col footer-contact">
				<h3 class="footer-title"><?php esc_html_e( 'تماس با ما', 'anishop' ); ?></h3>
				<ul class="footer-contact-list">
					<?php if ( $anishop_phone_f = get_theme_mod( 'anishop_phone', '۰۲۱-۹۱۰۰۹۱۰۰' ) ) : ?>
						<li><?php anishop_icon_e( 'headset', 18 ); ?><span><?php echo esc_html( $anishop_phone_f ); ?></span></li>
					<?php endif; ?>
					<?php if ( $anishop_email_f = get_theme_mod( 'anishop_email', 'info@anishop.ir' ) ) : ?>
						<li><?php anishop_icon_e( 'wallet', 18 ); ?><span><?php echo esc_html( $anishop_email_f ); ?></span></li>
					<?php endif; ?>
					<?php if ( $anishop_address_f = get_theme_mod( 'anishop_address', 'تهران، خیابان ولیعصر، مرکز موبایل ولیعصر' ) ) : ?>
						<li><?php anishop_icon_e( 'location', 18 ); ?><span><?php echo esc_html( $anishop_address_f ); ?></span></li>
					<?php endif; ?>
				</ul>
			</div>

		</div>
	</div>

	<div class="footer-bottom">
		<div class="container footer-bottom-inner">
			<p class="copyright">
				<?php
				printf(
					/* translators: 1: year, 2: site name */
					esc_html__( '%1$s %2$s — تمامی حقوق محفوظ است.', 'anishop' ),
					esc_html( anishop_fa_digits( date_i18n( 'Y' ) ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
			<p class="footer-note"><?php echo esc_html( get_theme_mod( 'anishop_footer_copyright', 'کلیه حقوق این وب‌سایت متعلق به آنی‌شاپ است.' ) ); ?></p>
		</div>
	</div>
</footer>

<div class="backdrop" id="page-backdrop" hidden></div>

<?php if ( anishop_is_woocommerce() && function_exists( 'wc_get_cart_url' ) ) : ?>
<div class="anishop-cart-drawer" id="cart-drawer" hidden>
	<div class="drawer-backdrop" data-cart-drawer-close></div>
	<div class="drawer-panel anishop-mini-cart-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'سبد خرید', 'anishop' ); ?>">
		<div class="drawer-head">
			<span class="drawer-title">
				<?php anishop_icon_e( 'cart', 20 ); ?>
				<?php esc_html_e( 'سبد خرید', 'anishop' ); ?>
				<span class="cart-count" data-cart-count><?php echo esc_html( anishop_fa_digits( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ) ); ?></span>
			</span>
			<button class="icon-btn" type="button" data-cart-drawer-close aria-label="<?php esc_attr_e( 'بستن', 'anishop' ); ?>"><?php anishop_icon_e( 'close', 22 ); ?></button>
		</div>

		<div class="anishop-mini-cart-content" data-mini-cart-body>
			<?php echo anishop_mini_cart_content( array( 'list_class' => 'mini-cart-list' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>

		<div class="cart-drawer-actions">
			<a class="btn btn-ghost" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'مشاهده سبد خرید', 'anishop' ); ?></a>
			<a class="btn btn-primary" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'تسویه حساب', 'anishop' ); ?></a>
		</div>
	</div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
