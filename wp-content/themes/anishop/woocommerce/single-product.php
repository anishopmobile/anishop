<?php
/**
 * Single product shell.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
	the_post();

	do_action( 'woocommerce_before_single_product' );
	?>

	<div class="container">
		<nav class="woo-breadcrumb single-breadcrumb"><?php woocommerce_breadcrumb(); ?></nav>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	</div>

	<?php
endwhile;

get_footer( 'shop' );
