<?php
/**
 * Shop archive (products page, categories, tags).
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$anishop_shop_page_id = wc_get_page_id( 'shop' );
$anishop_show_desc    = is_shop() && apply_filters( 'anishop_show_shop_description', true ) && get_post_field( 'post_content', $anishop_shop_page_id );
?>

<div class="container">

	<header class="woo-page-head">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woo-page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
		<nav class="woo-breadcrumb">
			<?php woocommerce_breadcrumb(); ?>
		</nav>
		<?php if ( $anishop_show_desc ) : ?>
			<div class="woo-page-desc"><?php echo wp_kses_post( wpautop( get_post_field( 'post_content', $anishop_shop_page_id ) ) ); ?></div>
		<?php endif; ?>
	</header>

	<div class="shop-layout">

		<aside class="shop-sidebar">
			<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'shop-sidebar' ); ?>
			<?php else : ?>
				<section class="widget">
					<h3 class="widget-title"><?php esc_html_e( 'دسته‌های محصول', 'anishop' ); ?></h3>
					<ul class="shop-cat-list">
						<?php
						wp_list_categories( array(
							'taxonomy'   => 'product_cat',
							'title_li'   => '',
							'hide_empty' => true,
						) );
						?>
					</ul>
				</section>
			<?php endif; ?>
		</aside>

		<div class="shop-main">
			<?php if ( have_posts() ) : ?>

				<?php do_action( 'woocommerce_before_shop_loop' ); ?>

				<?php
				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();
				?>

			<?php else : ?>
				<div class="empty-state">
					<?php anishop_icon_e( 'search', 44 ); ?>
					<p><?php esc_html_e( 'محصولی در این بخش پیدا نشد.', 'anishop' ); ?></p>
					<?php do_action( 'woocommerce_no_products_found' ); ?>
				</div>
			<?php endif; ?>

			<?php do_action( 'woocommerce_after_shop_loop' ); ?>
		</div>

	</div>
</div>

<?php
get_footer( 'shop' );
