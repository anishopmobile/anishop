<?php
/**
 * 404 template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="container">
	<div class="error-404">
		<p class="error-code">۴۰۴</p>
		<h1 class="error-title"><?php esc_html_e( 'صفحه‌ای که دنبالش بودی پیدا نشد!', 'anishop' ); ?></h1>
		<p class="error-text"><?php esc_html_e( 'ممکن است آدرس تغییر کرده یا صفحه حذف شده باشد.', 'anishop' ); ?></p>
		<div class="error-actions">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به خانه', 'anishop' ); ?></a>
			<a class="btn btn-ghost" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'فروشگاه', 'anishop' ); ?></a>
		</div>
		<div class="error-search"><?php get_search_form(); ?></div>
	</div>
</div>

<?php
get_footer();
