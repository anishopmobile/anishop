<?php
/**
 * Front page template.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

get_header();

anishop_get_template_part( 'front-hero' );
anishop_get_template_part( 'front-categories' );
anishop_get_template_part( 'front-deals' );

anishop_get_template_part( 'front-products', array(
	'type'  => 'bestselling',
	'title' => get_theme_mod( 'anishop_bestsellers_title', 'پرفروش‌ترین موبایل‌ها' ),
	'icon'  => 'fire',
	'limit' => 8,
) );

anishop_get_template_part( 'front-products', array(
	'type'  => 'newest',
	'title' => get_theme_mod( 'anishop_newest_title', 'جدیدترین کالاهای آنی‌شاپ' ),
	'icon'  => 'bolt',
	'limit' => 8,
) );

anishop_get_template_part( 'front-brands' );
anishop_get_template_part( 'front-blog' );

get_footer();
