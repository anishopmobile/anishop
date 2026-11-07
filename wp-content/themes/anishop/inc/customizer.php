<?php
/**
 * Customizer settings: contact info, topbar, home sections control, footer.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function anishop_customize_register( $wp_customize ) {

	/* ---------------------------- Contact info ---------------------------- */
	$wp_customize->add_section( 'anishop_contact', array(
		'title'       => __( 'اطلاعات تماس آنی‌شاپ', 'anishop' ),
		'priority'    => 25,
		'description' => __( 'این اطلاعات در هدر و فوتر نمایش داده می‌شود.', 'anishop' ),
	) );

	$wp_customize->add_setting( 'anishop_phone', array(
		'default'           => '۰۲۱-۹۱۰۰۹۱۰۰',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'anishop_phone', array(
		'label'   => __( 'شماره تلفن', 'anishop' ),
		'section' => 'anishop_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'anishop_email', array(
		'default'           => 'info@anishop.ir',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'anishop_email', array(
		'label'   => __( 'ایمیل', 'anishop' ),
		'section' => 'anishop_contact',
		'type'    => 'email',
	) );

	$wp_customize->add_setting( 'anishop_address', array(
		'default'           => 'تهران، خیابان ولیعصر، مرکز موبایل ولیعصر',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'anishop_address', array(
		'label'   => __( 'آدرس فروشگاه', 'anishop' ),
		'section' => 'anishop_contact',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'anishop_instagram', array(
		'default'           => 'https://instagram.com/anishop',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'anishop_instagram', array(
		'label'   => __( 'اینستاگرام', 'anishop' ),
		'section' => 'anishop_contact',
		'type'    => 'url',
	) );

	/* ------------------------------ Home page ----------------------------- */
	$wp_customize->add_section( 'anishop_home', array(
		'title'       => __( 'بخش‌های صفحه اصلی', 'anishop' ),
		'priority'    => 26,
		'description' => __( 'عناوین و محتوای بخش‌های صفحه اصلی را تنظیم کنید.', 'anishop' ),
	) );

	$anishop_home_fields = array(
		'hero_title'    => array( __( 'تیتر بزرگ اسلایدر', 'anishop' ), 'آنی‌شاپ؛ دنیای موبایل در دست تو' ),
		'hero_subtitle' => array( __( 'زیرتیتر اسلایدر', 'anishop' ), 'جدیدترین گوشی‌ها با گارانتی معتبر و قیمت رقابتی' ),
		'hero_btn'      => array( __( 'متن دکمه اسلایدر', 'anishop' ), 'مشاهده محصولات' ),
		'hero_url'      => array( __( 'لینک دکمه اسلایدر', 'anishop' ), '#' ),
		'deals_title'   => array( __( 'عنوان پیشنهاد شگفت‌انگیز', 'anishop' ), 'پیشنهاد شگفت‌انگیز' ),
		'brands_title'  => array( __( 'عنوان بخش برندها', 'anishop' ), 'برندهای محبوب' ),
		'blog_title'    => array( __( 'عنوان بخش وبلاگ', 'anishop' ), 'از مجله آنی‌شاپ' ),
	);

	foreach ( $anishop_home_fields as $anishop_key => $anishop_field ) {
		$wp_customize->add_setting( 'anishop_' . $anishop_key, array(
			'default'           => $anishop_field[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'anishop_' . $anishop_key, array(
			'label'   => $anishop_field[0],
			'section' => 'anishop_home',
			'type'    => 'text',
		) );
	}

	/* -------------------------------- Footer ------------------------------ */
	$wp_customize->add_section( 'anishop_footer', array(
		'title'    => __( 'فوتر', 'anishop' ),
		'priority' => 27,
	) );

	$wp_customize->add_setting( 'anishop_footer_about', array(
		'default'           => 'آنی‌شاپ، فروشگاه اینترنتی موبایل و لوازم جانبی با ضمانت اصالت کالا، ارسال سریع و پشتیبانی واقعی.',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'anishop_footer_about', array(
		'label'   => __( 'متن درباره ما (فوتر)', 'anishop' ),
		'section' => 'anishop_footer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'anishop_footer_copyright', array(
		'default'           => 'کلیه حقوق این وب‌سایت متعلق به آنی‌شاپ است.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'anishop_footer_copyright', array(
		'label'   => __( 'متن کپی‌رایت', 'anishop' ),
		'section' => 'anishop_footer',
		'type'    => 'text',
	) );
}
add_action( 'customize_register', 'anishop_customize_register' );
