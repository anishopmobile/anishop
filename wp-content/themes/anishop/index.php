<?php
/**
 * Main index template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="container page-wrap">
	<header class="page-head">
		<h1 class="page-title"><?php echo esc_html( is_home() ? get_the_title( get_option( 'page_for_posts' ) ) ?: __( 'مجله آنی‌شاپ', 'anishop' ) : get_bloginfo( 'name' ) ); ?></h1>
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
					'next_text' => anishop_icon( 'chevron-l', 18 ) . '<span class="screen-reader-text">' . __( 'بعدی', 'anishop' ) . '</span>',
				) );
				?>
			<?php else : ?>
				<p class="empty-note"><?php esc_html_e( 'هنوز مقاله‌ای منتشر نشده است.', 'anishop' ); ?></p>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
