<?php
/*
Plugin Name: Vanilla Bean - SEO Alert
Plugin URI: https://wordpress.org/plugins/seo-alert/
Description: Email report of visits from the seo bot.   --Vanilla Beans for Wordpress by Velvary Pty Ltd
Version: 1.00
Author: Mark Pottie <mark@pottie.com>
Author URI: http://www.pottie.com
License: GPLv2
*/
namespace VanillaBeans\SEOAlert;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !defined( 'VBEANSEOALERT_PLUGIN_DIR' ) ) {
	define( 'VBEANSEOALERT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'VBEANSEOALERT_PLUGIN_URL' ) ) {
	define( 'VBEANSEOALERT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'VBEANSEOALERT_PLUGIN_FILE' ) ) {
	define( 'VBEANSEOALERT_PLUGIN_FILE', __FILE__ );
}
if ( !defined( 'VBEANSEOALERT_PLUGIN_VERSION' ) ) {
	define( 'VBEANSEOALERT_PLUGIN_VERSION', '1.00' );
}


$includes = array(
	'functions.php'
);

$frontend_includes = array('request.php');


$adminincludes= array(
    'settings.php'
);

            // Load common includes
            foreach ( $includes as $include ) {
                    require_once( dirname( __FILE__ ) . '/inc/'. $include );
            }
            // Load admin only
	if(is_admin()){		//load admin part
            foreach ( $adminincludes as $admininclude ) {
                require_once( dirname( __FILE__ ) . '/inc/admin/'. $admininclude );
            }
	}else{		//load front part
            foreach ( $frontend_includes as $include ) {
                    require_once( dirname( __FILE__ ) . '/inc/'. $include );
            }
	}

        
add_action('admin_menu', 'VanillaBeans\SEOAlert\vbean_seoalert_create_menu');


if(!function_exists('vbean_seoalert_create_menu')){
function vbean_seoalert_create_menu() {

        if ( empty ( $GLOBALS['admin_page_hooks']['vanillabeans-settings'] ) ){
                //create new top-level menu
        	add_menu_page('Vanilla Beans', 'Vanilla Beans', 'administrator', 'vanillabeans-settings', 'VanillaBeans\LiveSettings', VBEANSEOALERT_PLUGIN_URL.'vicon.png', 4);
            
        }
        add_submenu_page('vanillabeans-settings', 'SEO Alert', 'SEO Alert', 'administrator', __FILE__,'VanillaBeans\SEOAlert\SettingsPage');
    

	//call register settings function
	add_action( 'admin_init', 'VanillaBeans\SEOAlert\RegisterSettings' );
}
}       
        