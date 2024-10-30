<?php 
/**
 * Plugin Name: Custom Colors for Real Estate Manager
 * Plugin URI: https://webcodingplace.com/real-estate-manager-wordpress-plugin/
 * Description: This plugin allows you make color changes in all templates used in Real Estate Manager.  
 * Version: 1.0
 * Author: Fayaz Ahmad Arslan
 * Author URI: https://www.webakesweb.com/
 * Text Domain: rem-color
 * License: GPL2
 */
if( ! defined('ABSPATH' ) ){
	exit;
}


define( 'REM_COLORS_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define( 'REM_COLORS_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );

class REM_COLORS {
	function  __construct()
	{
		
		add_action('admin_menu', array($this, 'add_color_menu'));
		add_action( 'admin_notices', array($this, 'check_if_rem_activated') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
		add_action( 'rem_css_kit_styles', array($this, 'add_colors_stylesheet' ) );
		add_action( 'wp_ajax_rem_color_save_settings', array($this, 'save_color_settings' ) );

	}

	function add_color_menu() {
	
		add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager Color', __( 'Custom Colors', 	'rem-color' ), 'manage_options', 'rem_colors', array($this, 'render_color_settings') );
	}

	function render_color_settings() {

		include 'menu-colors.php';
	}

	function admin_scripts ($check) {
		
		if ( $check == 'rem_property_page_rem_colors' ) {
           wp_enqueue_style( 'wp-color-picker' );
           wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
           wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
           wp_enqueue_script( 'rem-colors-js', REM_COLORS_URL . '/script.js' , array('jquery', 'wp-color-picker'));
       	}
	}

	function add_colors_stylesheet() {
		$saved_option = get_option('rem_color_settings');
		// var_dump($saved_option);
		$color_settings = $this-> admin_settings_fields();
		// var_dump($color_settings);
		foreach ($color_settings as $setting_value) {
			
			foreach ($setting_value['fields'] as $color_setting => $field_color ) {
				
				echo $field_color['selector']
						.'{'.
							$field_color['property'] .':'. $saved_option[$field_color['name']]
						.'; }';


			}
		}
	}

	function save_color_settings() {
		// var_dump("$_REQUSET");
		if (update_option( 'rem_color_settings', $_REQUEST )) {
			_e('All options are updated', 'rem-color');
		}
		
		die(0);
	}
	function check_if_rem_activated() {
        if (!class_exists('WCP_Real_Estate_Management')) { ?>
            <div class="notice notice-info is-dismissible">
                <p>Please install and activate <a target="_blank" href="https://wordpress.org/plugins/real-estate-manager/">Real Estate Manager</a> for using <strong>REM Colors</strong></p>
            </div>
        <?php }
    }

    function admin_settings_fields(){
    	
    	include 'admin-settings.php';

		return $settings;
    }

    function render_setting_field($field){
    	include 'render-admin-settings.php';
    }
}

$rem_colors_obj = new REM_COLORS;