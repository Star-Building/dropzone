<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:     Dropzone Manager for WordPress
 * Plugin URI:      https://github.com/georgemck/dropzone
 * Description:     Activate Dropzone. This plugin is an open source project, made possible by your contribution (code). Development is done on GitHub.
 * Version:         0.5.0
 * Author:          George McKinney
 * Author URI:      https://twitter.com/georgemck
 * License:			GPLv3
 * License URI:		https://www.gnu.org/licenses/gpl-3.0
 * Text Domain:		wp-dropzone-manager
 * Domain Path:		/languages
 */

// If this file is called directly, abort.
defined('ABSPATH') or exit();

if ( defined('WP_CLI') && WP_CLI ) {
     $_SERVER['HTTP_HOST'] = 'localhost';
}

// Config - CONSTANTS
// http://php.net/manual/en/dir.constants.php & https://www.quora.com/Should-class-constants-be-all-uppercase-in-PHP
// define( 'CONSTANT', $_SERVER['HTTP_HOST'] );

// Dropzone versions, don't forget to update the files! .js and .min.js are automatically added accordingly at the end of the name/file.
define( 'WP_DROPZONE_MANAGER_PLUGIN_DROPZONE_5X', 'dropzone-5.7.0' );

// Settings
//$wp_dropzone_manager_plugin_dropzone_settings = (array) get_option( 'wp_dropzone_manager_plugin_dropzone_settings' );

// Include weDevs Settings API wrapper class
//require WP_DROPZONE_MANAGER_PLUGIN_DIR_PATH . 'inc/settings-api.php';

// All filters
//add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wp_dropzone_manager_plugin_add_action_links' );

// All actions
//add_action( 'admin_init', array( 'PAnD', 'init' ) );
//add_action( 'admin_notices', 'wp_dropzone_manager_plugin_admin_notice' );

// Add settings link to our plugin section on the plugin list page
function wp_dropzone_manager_plugin_add_action_links ( $links ) {
	$plugin_links = array(
		'<a href="' . WP_DROPZONE_MANAGER_PLUGIN_ADMIN_URL . '">Settings</a>',
	);

	return array_merge( $links, $plugin_links );
}

// Activation process
//register_activation_hook( __FILE__, 'wp_dropzone_manager_plugin_activation' );

function wp_dropzone_manager_plugin_activation() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
    	exit;
    }

    global $wp_version;
	$php = '5.6';
	$wp  = '5.3';

	if ( version_compare( PHP_VERSION, $php, '<' ) || version_compare( $wp_version, $wp, '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) );
		wp_die(
			'<p>' .
			sprintf(
				__( 'This plugin can not be activated because either your WordPress installation has an outdated/unsupported PHP version or you are using an outdated/old WordPress version.<br><br>This plugin requires a minimum of <strong>PHP 5.6 or greater</strong> and <strong>WordPress 4.9 or greater</strong>.<br><br> Your install:<br><strong>PHP: ' . PHP_VERSION .  '</strong><br><strong>WordPress: ' . $wp_version . '</strong><br><br>You need to update either one of them or both, before you are able to activate and use this plugin.<br>- <a href="https://wordpress.org/support/update-php/" target="_blank" rel="noopener noreferrer">Learn more about updating PHP</a><br>- <a href="https://wordpress.org/support/article/updating-wordpress/" target="_blank" rel="noopener noreferrer">Learn more about updating WordPress</a>', 'wp_jquery_manager_plugin' ),
				$php
			)
			. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'wp_dropzone_manager_plugin' ) . '</a>'
		);
	}
}

// Deactivation
//register_deactivation_hook( __FILE__, 'wp_dropzone_manager_plugin_deactivation' );

function wp_dropzone_manager_plugin_deactivation() {
	delete_option( 'wp_dropzone_manager_plugin_dropzone_settings' );
	delete_option( 'wp_dropzone_manager_plugin_dropzone_migrate_settings' );
}
