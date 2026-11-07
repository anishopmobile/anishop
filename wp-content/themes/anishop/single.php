<?php
/**
 * Single post template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="container page-wrap">
		<article <?php post_class( 'single-post' ); ?>>
			<header class="single-head">
				<h1 class="single-title"><?php the_title(); ?></h1>
				<div class="single-meta">
					<span><?php anishop_icon_e( 'clock', 15 ); ?> <?php echo esc_html( get_the_date() ); ?></span>
					<span><?php anishop_icon_e( 'user', 15 ); ?> <?php the_author(); ?></span>
					<?php if ( has_category() ) : ?>
						<span><?php the_category( '، ' ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single-thumb"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>

			<div class="single-content entry-content">
				<?php the_content(); ?>
			</div>

			<?php if ( has_tag() ) : ?>
				<footer class="single-tags"><?php the_tags( '', ' ' ); ?></footer>
			<?php endif; ?>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	</div>
	<?php
endwhile;

get_footer();
