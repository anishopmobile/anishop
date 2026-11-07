<?php
/**
 * Front page: hero slider + side cards.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

$anishop_hero_title    = get_theme_mod( 'anishop_hero_title', 'آنی‌شاپ؛ دنیای موبایل در دست تو' );
$anishop_hero_subtitle = get_theme_mod( 'anishop_hero_subtitle', 'جدیدترین گوشی‌ها با گارانتی معتبر و قیمت رقابتی' );
$anishop_hero_btn      = get_theme_mod( 'anishop_hero_btn', 'مشاهده محصولات' );
$anishop_hero_url      = get_theme_mod( 'anishop_hero_url', '#' );
?>
<section class="hero container">
	<div class="hero-slider" data-slider>

		<?php for ( $anishop_i = 1; $anishop_i <= 3; $anishop_i++ ) : ?>

			<?php
			$anishop_slide_title    = get_theme_mod( "anishop_hero{$anishop_i}_title", $anishop_hero_title );
			$anishop_slide_subtitle = get_theme_mod( "anishop_hero{$anishop_i}_subtitle", $anishop_hero_subtitle );
			$anishop_slide_btn      = get_theme_mod( "anishop_hero{$anishop_i}_btn", $anishop_hero_btn );
			$anishop_slide_url      = get_theme_mod( "anishop_hero{$anishop_i}_url", $anishop_hero_url );

			$anishop_slide_img = get_theme_mod( "anishop_hero{$anishop_i}_image" );
			$anishop_bg        = $anishop_slide_img
				? 'style="background-image:url(' . esc_url( $anishop_slide_img ) . ')"'
				: '';
			?>

			<input type="radio" name="hero-slide" id="hero-slide-<?php echo (int) $anishop_i; ?>" class="hero-slide-state" <?php checked( 1, $anishop_i ); ?>>

		<?php endfor; ?>

		<div class="hero-slides">
			<?php for ( $anishop_i = 1; $anishop_i <= 3; $anishop_i++ ) : ?>

				<?php
				$anishop_slide_title    = get_theme_mod( "anishop_hero{$anishop_i}_title", $anishop_hero_title );
				$anishop_slide_subtitle = get_theme_mod( "anishop_hero{$anishop_i}_subtitle", $anishop_hero_subtitle );
				$anishop_slide_btn      = get_theme_mod( "anishop_hero{$anishop_i}_btn", $anishop_hero_btn );
				$anishop_slide_url      = get_theme_mod( "anishop_hero{$anishop_i}_url", $anishop_hero_url );

				$anishop_slide_img = get_theme_mod( "anishop_hero{$anishop_i}_image" );
				$anishop_bg        = $anishop_slide_img
					? ' style="background-image:url(' . esc_url( $anishop_slide_img ) . ')"'
					: '';
				?>

				<div class="hero-slide<?php echo ( 1 === $anishop_i ) ? ' is-active' : ''; ?>" data-slide<?php echo $anishop_bg; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<div class="hero-slide-content">
						<span class="hero-kicker"><?php esc_html_e( 'فروشگاه تخصصی موبایل', 'anishop' ); ?></span>
						<h2 class="hero-title"><?php echo esc_html( $anishop_slide_title ); ?></h2>
						<p class="hero-subtitle"><?php echo esc_html( $anishop_slide_subtitle ); ?></p>
						<a class="btn btn-primary hero-cta" href="<?php echo esc_url( $anishop_slide_url ); ?>">
							<?php echo esc_html( $anishop_slide_btn ); ?>
							<?php anishop_icon_e( 'chevron-l', 18 ); ?>
						</a>
					</div>
					<div class="hero-slide-art" aria-hidden="true">
						<?php anishop_icon_e( 'phone', 120 ); ?>
					</div>
				</div>

			<?php endfor; ?>
		</div>

		<div class="hero-dots">
			<?php for ( $anishop_i = 1; $anishop_i <= 3; $anishop_i++ ) : ?>
				<label for="hero-slide-<?php echo (int) $anishop_i; ?>" class="hero-dot" data-dot="<?php echo (int) $anishop_i; ?>"></label>
			<?php endfor; ?>
		</div>

		<button class="hero-arrow hero-arrow-prev" data-slider-prev aria-label="<?php esc_attr_e( 'اسلاید قبلی', 'anishop' ); ?>">
			<?php anishop_icon_e( 'chevron', 20 ); ?>
		</button>
		<button class="hero-arrow hero-arrow-next" data-slider-next aria-label="<?php esc_attr_e( 'اسلاید بعدی', 'anishop' ); ?>">
			<?php anishop_icon_e( 'chevron-l', 20 ); ?>
		</button>
	</div>

	<aside class="hero-side">
		<a class="hero-side-card hero-side-card-1" href="<?php echo esc_url( get_theme_mod( 'anishop_hero_side1_url', '#' ) ); ?>">
			<?php anishop_icon_e( 'audio', 34 ); ?>
			<strong><?php esc_html_e( 'هدفون و ایرپاد', 'anishop' ); ?></strong>
			<span><?php esc_html_e( 'از ۴۹۰ هزار تومان', 'anishop' ); ?></span>
		</a>
		<a class="hero-side-card hero-side-card-2" href="<?php echo esc_url( get_theme_mod( 'anishop_hero_side2_url', '#' ) ); ?>">
			<?php anishop_icon_e( 'watch', 34 ); ?>
			<strong><?php esc_html_e( 'ساعت هوشمند', 'anishop' ); ?></strong>
			<span><?php esc_html_e( 'با ۲۵٪ تخفیف', 'anishop' ); ?></span>
		</a>
		<a class="hero-side-card hero-side-card-3" href="<?php echo esc_url( get_theme_mod( 'anishop_hero_side3_url', '#' ) ); ?>">
			<?php anishop_icon_e( 'shield', 34 ); ?>
			<strong><?php esc_html_e( 'گارانتی اصالت', 'anishop' ); ?></strong>
			<span><?php esc_html_e( 'برای همه کالاها', 'anishop' ); ?></span>
		</a>
	</aside>
</section>
