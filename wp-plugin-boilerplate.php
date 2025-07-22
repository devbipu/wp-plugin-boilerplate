<?php

/**
 * Plugin Name: WP Plugin Boilerplate
 * Plugin URI: https://github.com/devbipu/wp-plugin-boilerplate
 * Description: A WordPress plugin...
 * Version: 1.0.0
 * Author: Bipu
 * Author URI: https://bipu.dev
 * Text Domain: wp-plugin-boilerplate
 * Domain Path: /languages
 * Requires at least: 7.4
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('PLUGIN_NAME', 'wp-plugin-boilerplate');
define('PLUGIN_VERSION', '1.0.0');
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoloader
require_once PLUGIN_DIR . 'vendor/autoload.php';


// Helper functions
require_once PLUGIN_DIR . 'src/helper.php';

// Register activation hook
register_activation_hook(__FILE__, function () {
    $plugin = \Devbipu\WPpluginBoilerplate\Plugin::get_instance();
    $plugin->activate();
});

// Initialize the plugin
add_action('plugins_loaded', function () {
    \Devbipu\WPpluginBoilerplate\Plugin::get_instance();
}, 20);

// Initialize logger after WordPress is loaded
add_action('init', function () {}, 20);

// Deactivation hook
register_deactivation_hook(__FILE__, function () {
    \Devbipu\WPpluginBoilerplate\Plugin::get_instance()->deactivate();
});
