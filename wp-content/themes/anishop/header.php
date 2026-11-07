<?php
/**
 * Header template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'پرش به محتوا', 'anishop' ); ?></a>

<header class="site-header" id="site-header">

	<?php if ( is_active_sidebar( 'topbar' ) || has_nav_menu( 'topbar' ) || get_theme_mod( 'anishop_phone' ) ) : ?>
	<div class="topbar">
		<div class="container topbar-inner">
			<div class="topbar-contact">
				<?php if ( $anishop_phone = get_theme_mod( 'anishop_phone', '۰۲۱-۹۱۰۰۹۱۰۰' ) ) : ?>
					<span class="topbar-item"><?php anishop_icon_e( 'headset', 16 ); ?><span><?php echo esc_html( $anishop_phone ); ?></span></span>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'topbar' ) ) : ?>
					<?php wp_nav_menu( array(
						'theme_location' => 'topbar',
						'container'      => false,
						'menu_class'     => 'topbar-menu',
						'depth'          => 1,
						'fallback_cb'    => false,
					) ); ?>
				<?php endif; ?>
			</div>
			<div class="topbar-badge">
				<?php anishop_icon_e( 'bolt', 15 ); ?>
				<span><?php esc_html_e( '۷ روز ضمانت بازگشت کالا', 'anishop' ); ?></span>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="header-main">
		<div class="container header-main-inner">

			<button class="icon-btn mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-drawer" data-drawer-toggle="mobile-drawer">
				<?php anishop_icon_e( 'menu', 24 ); ?>
				<span class="screen-reader-text"><?php esc_html_e( 'منو', 'anishop' ); ?></span>
			</button>

			<div class="branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="site-logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<span class="logo-mark"><?php anishop_icon_e( 'phone', 20 ); ?></span>
						<span class="logo-text">آنی‌<em>شاپ</em></span>
					</a>
				<?php endif; ?>
			</div>

			<div class="header-search">
				<?php get_search_form(); ?>
			</div>

			<div class="header-actions">
				<?php if ( anishop_is_woocommerce() ) : ?>
					<?php if ( is_user_logged_in() ) : ?>
						<a class="icon-btn header-account" href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" title="<?php esc_attr_e( 'حساب کاربری', 'anishop' ); ?>">
							<?php anishop_icon_e( 'user', 22 ); ?>
						</a>
					<?php else : ?>
						<a class="icon-btn header-account" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" title="<?php esc_attr_e( 'ورود / ثبت‌نام', 'anishop' ); ?>">
							<?php anishop_icon_e( 'user', 22 ); ?>
						</a>
					<?php endif; ?>

					<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
						<button class="icon-btn header-cart" type="button" aria-controls="cart-drawer" aria-expanded="false" data-cart-drawer-toggle title="<?php esc_attr_e( 'سبد خرید', 'anishop' ); ?>">
							<?php anishop_icon_e( 'cart', 22 ); ?>
							<span class="cart-count" data-cart-count><?php echo esc_html( anishop_fa_digits( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ) ); ?></span>
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>

		</div>
	</div>

	<nav class="primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'anishop' ); ?>">
		<div class="container">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'primary-menu',
				'fallback_cb'    => 'anishop_primary_menu_fallback',
				'depth'          => 2,
			) );
			?>
		</div>
	</nav>
</header>

<div class="mobile-drawer" id="mobile-drawer" hidden>
	<div class="drawer-backdrop" data-drawer-close></div>
	<div class="drawer-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'منوی موبایل', 'anishop' ); ?>">
		<div class="drawer-head">
			<span class="drawer-title"><?php esc_html_e( 'منو', 'anishop' ); ?></span>
			<button class="icon-btn" data-drawer-close><?php anishop_icon_e( 'close', 22 ); ?></button>
		</div>
		<div class="drawer-search"><?php get_search_form(); ?></div>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'drawer-menu',
			'fallback_cb'    => 'anishop_primary_menu_fallback',
			'depth'          => 2,
		) );
		?>
	</div>
</div>

<?php if ( function_exists( 'wc_get_cart_url' ) && ! is_cart() && ! is_checkout() ) : ?>
	<button type="button" class="mobile-cart-fab" aria-controls="cart-drawer" aria-expanded="false" data-cart-drawer-toggle aria-label="<?php esc_attr_e( 'سبد خرید', 'anishop' ); ?>">
		<?php anishop_icon_e( 'cart', 22 ); ?>
		<span class="cart-count" data-cart-count><?php echo esc_html( anishop_fa_digits( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ) ); ?></span>
	</button>
<?php endif; ?>

<main id="main" class="site-main">
