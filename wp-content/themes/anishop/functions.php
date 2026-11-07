<?php
/**
 * Anishop theme bootstrap.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

define( 'ANISHOP_VERSION', '1.0.2' );
define( 'ANISHOP_DIR', get_template_directory() );
define( 'ANISHOP_URI', get_template_directory_uri() );

require_once ANISHOP_DIR . '/inc/setup.php';
require_once ANISHOP_DIR . '/inc/helpers.php';
require_once ANISHOP_DIR . '/inc/template-functions.php';
require_once ANISHOP_DIR . '/inc/enqueue.php';
require_once ANISHOP_DIR . '/inc/customizer.php';

if ( anishop_is_woocommerce() ) {
	require_once ANISHOP_DIR . '/inc/woocommerce.php';
}
