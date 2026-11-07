<?php
/**
 * Search results template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="container page-wrap">
	<header class="page-head">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'نتایج جستجو برای: %s', 'anishop' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="content-grid">
			<div class="content-area">
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
					'prev_text' => anishop_icon( 'chevron', 18 ) . '<span class="screen-reader-text">' . esc_html__( 'قبلی', 'anishop' ) . '</span>',
					'next_text' => anishop_icon( 'chevron-l', 18 ) . '<span class="screen-reader-text">' . esc_html__( 'بعدی', 'anishop' ) . '</span>',
				) );
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	<?php else : ?>
		<div class="empty-state">
			<?php anishop_icon_e( 'search', 44 ); ?>
			<p><?php esc_html_e( 'چیزی پیدا نشد. عبارت دیگری را امتحان کنید.', 'anishop' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
