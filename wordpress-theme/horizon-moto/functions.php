<?php
/**
 * Horizon Moto Guides theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HM_VERSION', '1.0.0' );
define( 'HM_DIR', get_template_directory() );

require HM_DIR . '/inc/helpers.php';
require HM_DIR . '/inc/post-types.php';
require HM_DIR . '/inc/fields.php';
require HM_DIR . '/inc/customizer.php';
require HM_DIR . '/inc/forms.php';
require HM_DIR . '/inc/demo-content.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array(
		'primary' => __( 'Main menu (header and footer "Explore")', 'horizon-moto' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'hm-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'hm-style', get_stylesheet_uri(), array( 'hm-fonts' ), HM_VERSION );
	wp_enqueue_script( 'hm-main', get_template_directory_uri() . '/assets/js/main.js', array(), HM_VERSION, true );
} );

add_filter( 'excerpt_length', function () {
	return 28;
} );
