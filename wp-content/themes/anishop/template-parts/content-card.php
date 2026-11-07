<?php
/**
 * Blog card.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;
?>
<article <?php post_class( 'blog-card' ); ?>>
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
		<div class="blog-card-meta">
			<span><?php anishop_icon_e( 'clock', 14 ); ?> <?php echo esc_html( get_the_date() ); ?></span>
		</div>
	</div>
</article>
