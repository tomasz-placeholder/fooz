<?php
/**
 * Fooz Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package twentytwentyfive-child
 */

add_action( 'wp_enqueue_scripts', 'twentytwentyfive_child_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function twentytwentyfive_child_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'twentytwentyfive-style', get_template_directory_uri() . '/style.css', array(), '0.1.0' );
	wp_enqueue_style(
		'fooz-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentytwentyfive-style' ),
		'0.1.0'
	);


	wp_enqueue_script(
		'fooz-script',
		get_stylesheet_directory_uri() . '/assets/js/scripts.js',
		array(),
		'1.0.0',
		true
	);
}
