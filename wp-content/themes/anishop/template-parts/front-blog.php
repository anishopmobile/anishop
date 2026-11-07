<?php
/**
 * Front page: latest blog posts.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

$anishop_blog_query = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
) );

if ( ! $anishop_blog_query->have_posts() ) {
	return;
}

$anishop_blog_title = get_theme_mod( 'anishop_blog_title', 'از مجله آنی‌شاپ' );
?>
<section class="home-section container" id="home-blog">
	<header class="section-head">
		<div class="section-head-title">
			<?php anishop_icon_e( 'clock', 22 ); ?>
			<h2 class="section-title"><?php echo esc_html( $anishop_blog_title ); ?></h2>
		</div>
		<span class="section-line" aria-hidden="true"></span>
		<a class="section-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">
			<?php esc_html_e( 'همه مقالات', 'anishop' ); ?>
			<?php anishop_icon_e( 'chevron-l', 16 ); ?>
		</a>
	</header>

	<div class="blog-grid">
		<?php
		while ( $anishop_blog_query->have_posts() ) :
			$anishop_blog_query->the_post();
			?>
			<article class="blog-card">
				<a class="blog-card-media" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
					<?php else : ?>
						<span class="blog-card-placeholder"><?php anishop_icon_e( 'clock', 28 ); ?></span>
					<?php endif; ?>
				</a>
				<div class="blog-card-body">
					<h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
					<a class="blog-card-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'ادامه مطلب', 'anishop' ); ?> <?php anishop_icon_e( 'chevron-l', 14 ); ?></a>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php
wp_reset_postdata();
