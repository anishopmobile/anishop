<?php
/**
 * Archive template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="container page-wrap">
	<header class="page-head">
		<h1 class="page-title"><?php the_archive_title(); ?></h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="page-desc"><?php the_archive_description(); ?></div>
		<?php endif; ?>
	</header>

	<div class="content-grid">
		<div class="content-area">
			<?php if ( have_posts() ) : ?>
				<div class="blog-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					?>
				</div>
				<?php
				the_posts_pagination( array(
					'prev_text' => anishop_icon( 'chevron', 18 ) . '<span class="screen-reader-text">' . __( 'قبلی', 'anishop' ) . '</span>',
					'next_text' => esc_html__( 'بعدی', 'anishop' ),
				) );
				?>
			<?php else : ?>
				<p class="empty-note"><?php esc_html_e( 'موردی یافت نشد.', 'anishop' ); ?></p>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
