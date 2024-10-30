<?php 

/** 
*Plugin Name:  user friendly logo slider
*Description: Wordpress Logo Slider Plugin 
* Version: 1.0.0
* Author: Infoseek Team
* Author URI: http://infoseeksoftwaresystems.com/
* License: GPL2
*/
include('includes/create-fields-settings.php');
include('includes/logo-settings.php');
function my5tech_ufls_enqueue_script()
{
	wp_enqueue_style( 'owl-theme-default-min-css', plugin_dir_url( __FILE__ ) . 'css/owl.theme.default.min.css' ); 
	wp_enqueue_style( 'owl-carousel-min-css', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css' );	
    wp_register_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array('jquery') );
	wp_enqueue_script('owl-carousel');
}
add_action('wp_enqueue_scripts', 'my5tech_ufls_enqueue_script');

