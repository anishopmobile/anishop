<?php
/**
 * Blog sidebar.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>
<aside class="site-sidebar">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>
