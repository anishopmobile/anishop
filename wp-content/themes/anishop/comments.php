<?php
/**
 * Comments template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: %s: comment count */
				esc_html( _n( '%s دیدگاه', '%s دیدگاه', get_comments_number(), 'anishop' ) ),
				esc_html( anishop_fa_digits( number_format_i18n( get_comments_number() ) ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'prev_text' => anishop_icon( 'chevron', 18 ),
			'next_text' => anishop_icon( 'chevron-l', 18 ),
		) );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="comments-closed"><?php esc_html_e( 'امکان ارسال دیدگاه بسته شده است.', 'anishop' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'         => __( 'دیدگاه خود را بنویسید', 'anishop' ),
		'label_submit'        => __( 'ارسال دیدگاه', 'anishop' ),
		'comment_notes_before' => '',
	) );
	?>
</section>
