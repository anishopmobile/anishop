<?php
/**
 * Anishop theme setup.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme supports and registration.
 */
function anishop_setup() {
	load_theme_textdomain( 'anishop', ANISHOP_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );

	add_theme_support( 'custom-logo', array(
		'height'      => 90,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 400,
		'single_image_width'    => 700,
		'product_grid'          => array(
			'default_rows'    => 2,
			'min_rows'        => 1,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 6,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'منوی اصلی', 'anishop' ),
		'topbar'  => __( 'منوی نوار بالا', 'anishop' ),
		'footer1' => __( 'فوتر — ستون ۱', 'anishop' ),
		'footer2' => __( 'فوتر — ستون ۲', 'anishop' ),
		'footer3' => __( 'فوتر — ستون ۳', 'anishop' ),
	) );

	add_image_size( 'anishop-cat', 160, 160, true );
	add_image_size( 'anishop-slide', 1140, 520, true );

	set_post_thumbnail_size( 800, 450, true );
}
add_action( 'after_setup_theme', 'anishop_setup' );

/**
 * Content width.
 */
function anishop_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'anishop_content_width', 0 );

/**
 * Widget areas.
 */
function anishop_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'ستون کناری فروشگاه', 'anishop' ),
		'id'            => 'shop-sidebar',
		'description'   => __( 'ابزارک‌های فیلتر محصولات در صفحه فروشگاه', 'anishop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'ستون کناری وبلاگ', 'anishop' ),
		'id'            => 'blog-sidebar',
		'description'   => __( 'ابزارک‌های ستون کناری وبلاگ', 'anishop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'anishop_widgets_init' );

/**
 * Body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function anishop_body_classes( $classes ) {
	$classes[] = 'anishop';
	if ( is_rtl() ) {
		$classes[] = 'anishop-rtl';
	}
	if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
		$classes[] = 'no-shop-sidebar';
	}
	return $classes;
}
add_filter( 'body_class', 'anishop_body_classes' );

/**
 * Excerpt tweaks.
 */
function anishop_excerpt_length( $length ) {
	return is_admin() ? $length : 22;
}
add_filter( 'excerpt_length', 'anishop_excerpt_length' );

function anishop_excerpt_more( $more ) {
	return is_admin() ? $more : ' …';
}
add_filter( 'excerpt_more', 'anishop_excerpt_more' );
