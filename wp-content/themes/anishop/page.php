<?php
/**
 * Page template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="container page-wrap">
		<article <?php post_class( 'single-page' ); ?>>
			<header class="page-head">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content single-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<nav class="page-links">',
					'after'  => '</nav>',
				) );
				?>
			</div>
		</article>
	</div>
	<?php
endwhile;

get_footer();
