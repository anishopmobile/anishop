<?php
/**
 * Search form.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

$anishop_search_action = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$anishop_post_type     = function_exists( 'wc_get_page_permalink' ) ? 'product' : 'post';
?>
<form role="search" method="get" class="anishop-searchform" action="<?php echo esc_url( $anishop_search_action ); ?>">
	<label class="screen-reader-text" for="anishop-search-field"><?php esc_html_e( 'جستجو در محصولات', 'anishop' ); ?></label>
	<input type="search" id="anishop-search-field" class="search-field" name="s"
		placeholder="<?php esc_attr_e( 'جستجوی محصول، برند و …', 'anishop' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>">
	<input type="hidden" name="post_type" value="<?php echo esc_attr( $anishop_post_type ); ?>">
	<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'جستجو', 'anishop' ); ?>">
		<?php anishop_icon_e( 'search', 20 ); ?>
	</button>
</form>
