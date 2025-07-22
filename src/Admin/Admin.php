<?php

namespace Devbipu\WpPluginBoilerplate\Admin;

class Admin
{
	/**
	 * Initialize admin functionality
	 */
	public function __construct()
	{
		add_action('admin_menu', [$this, 'add_menu_pages']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_ajax_' . PLUGIN_NAME . '_update_provider', [$this, 'handle_update_provider']);
	}

	/**
	 * Add admin menu pages
	 */
	public function add_menu_pages()
	{
		add_menu_page(
			PLUGIN_NAME,
			PLUGIN_NAME,
			'manage_options',
			'rv-affiliate-search',
			[$this, 'render_dashboard_page'],
			'dashicons-search',
			30
		);

		// add_submenu_page(
		// 	PLUGIN_NAME,
		// 	'Settings',
		// 	'Settings',
		// 	'manage_options',
		// 	PLUGIN_NAME . '-providers',
		// 	[$this, 'render_providers_page']
		// );
	}

	/**
	 * Enqueue admin scripts and styles
	 */
	public function enqueue_scripts($hook)
	{
		if (strpos($hook, PLUGIN_NAME) === false) {
			return;
		}

		wp_enqueue_style(
			PLUGIN_NAME . '-admin',
			plugins_url('assets/css/admin.css', dirname(dirname(__FILE__))),
			[],
			'1.0.0'
		);

		wp_enqueue_script(
			PLUGIN_NAME . '-admin',
			plugins_url('assets/js/admin.js', dirname(dirname(__FILE__))),
			['jquery'],
			'1.0.0',
			true
		);

		wp_localize_script(PLUGIN_NAME . '-admin', kebabToCamelCase(PLUGIN_NAME), [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce(PLUGIN_NAME)
		]);
	}


	/**
	 * Render dashboard page
	 */
	public function render_dashboard_page()
	{
		require_once plugin_dir_path(__FILE__) . 'views/dashboard.php';
	}
}
