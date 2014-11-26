<?php
/*
Plugin Name: Easy Slider Widget (Lite)
Plugin URI: http://www.ghozylab.com/plugins/
Description: Easy Slider Widget (Lite) - Displaying your image as slider in widget/sidebar area with very easy. Allows you to customize it to looking exactly what you want.
Author: GhozyLab, Inc.
Version: 1.0.0
Author URI: http://www.ghozylab.com/plugins/
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}

/*
|--------------------------------------------------------------------------
| Requires Wordpress Version
|--------------------------------------------------------------------------
*/
function ewic_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );

	if ( version_compare( $wp_version, "3.5", "<" ) ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
			wp_die( "This plugin requires WordPress 3.5 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
		}
	}
}
add_action( 'admin_init', 'ewic_wordpress_version' );


/*-------------------------------------------------------------------------------*/
/*   MAIN DEFINES
/*-------------------------------------------------------------------------------*/
if ( !defined( 'EWIC_VERSION' ) ) {
	define( 'EWIC_VERSION', '1.0.0' );
	}

if ( !defined( 'EWIC_NAME' ) ) {
	define( 'EWIC_NAME', 'Easy Slider Widget' );
	}


/*-------------------------------------------------------------------------------*/
/*   Load WP jQuery library
/*-------------------------------------------------------------------------------*/
function ewic_enqueue_scripts() {
	if( !is_admin() )
		{
			wp_enqueue_script( 'jquery' );
			}
}

if ( !is_admin() )
{
  add_action( 'init', 'ewic_enqueue_scripts' );
}


/*-------------------------------------------------------------------------------*/
/*   I18N - LOCALIZATION
/*-------------------------------------------------------------------------------*/
function ewic_lang_init() {
	load_plugin_textdomain( 'easywic', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
add_action( 'init', 'ewic_lang_init' );


/*-------------------------------------------------------------------------------*/
/*   Registers custom post type
/*-------------------------------------------------------------------------------*/
function ewic_post_type() {
	$labels = array(
		'name' 				=> _x( 'Easy Slider', 'post type general name' ),
		'singular_name'		=> _x( 'Easy Slider', 'post type singular name' ),
		'add_new' 			=> __( 'Add New Slider', 'easywic' ),
		'add_new_item' 		=> __( 'Easy Slider Item', 'easywic' ),
		'edit_item' 		=> __( 'Edit Slider', 'easywic' ),
		'new_item' 			=> __( 'New Slider', 'easywic' ),
		'view_item' 		=> __( 'View Slider', 'easywic' ),
		'search_items' 		=> __( 'Search Slider', 'easywic' ),
		'not_found' 		=> __( 'No Slider Found', 'easywic' ),
		'not_found_in_trash'=> __( 'No Slider Found In Trash', 'easywic' ),
		'parent_item_colon' => __( 'Parent Slider', 'easywic' ),
		'menu_name'			=> __( 'Easy Slider', 'easywic' )
	);

	$taxonomies = array();
	$supports = array( 'title' );
	
	$post_type_args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __( 'Easy Slider', 'easywic' ),
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'hierarchical' 		=> false,
		'rewrite' 			=> array( 'slug' => 'easyimagesldr', 'with_front' => false ),
		'supports' 			=> $supports,
		'menu_position' 	=> 20,
		'menu_icon' =>  plugins_url( 'inc/images/ewic-cp-icon.png' , __FILE__ ),		
		'taxonomies'		=> $taxonomies
	);

	 register_post_type( 'easyimageslider', $post_type_args );
}
add_action( 'init', 'ewic_post_type' );


/*-------------------------------------------------------------------------------*/
/*  Rename Sub Menu
/*-------------------------------------------------------------------------------*/
function ewic_rename_submenu() {  
    global $submenu;     
	$submenu['edit.php?post_type=easyimageslider'][5][0] = __( 'Overview', 'easywic' );  
}  
add_action( 'admin_menu', 'ewic_rename_submenu' );  

/*-------------------------------------------------------------------------------*/
/*  All Includes
/*-------------------------------------------------------------------------------*/

include_once( 'inc/functions/ewic-functions.php' ); 
include_once( 'inc/ewic-frontend.php' );
include_once( 'inc/ewic-metaboxes.php' ); 
include_once( 'inc/ewic-widget.php' ); 

/*-------------------------------------------------------------------------------*/
/*   Featured Plugins Page
/*-------------------------------------------------------------------------------*/
if ( is_admin() ){
	require_once( 'inc/ewic-featured.php' );
	}


?>