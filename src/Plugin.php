<?php

namespace Devbipu\WpPluginBoilerplate;

class Plugin
{
    private static $instance = null;
    private $admin;
    private $database;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->init_hooks();
    }

    private function init_hooks()
    {
        // Initialize components
        $this->database = Database::get_instance();

        // Admin initialization
        if (is_admin()) {
            $this->admin = new Admin\Admin();
        }

        // Add activation hook
        register_activation_hook(PLUGIN_DIR . 'wp-plugin-boilerplate.php', [$this, 'activate']);

        // Add deactivation hook
        register_deactivation_hook(PLUGIN_DIR . 'wp-plugin-boilerplate.php', [$this, 'deactivate']);
    }

    public function activate()
    {
        try {
            // Create database tables and insert default providers
            $this->database->create_tables()->insert_default_providers();
        } catch (\Exception $e) {
            // Log the error
            error_log('RV Affiliate Search activation error: ' . $e->getMessage());

            // Deactivate the plugin
            deactivate_plugins(plugin_basename(PLUGIN_DIR . 'wp-plugin-boilerplate.php'));

            // Display error message
            wp_die(
                'Error activating ' . PLUGIN_NAME . '.: ' . esc_html($e->getMessage()),
                'Plugin Activation Error',
                ['back_link' => true]
            );
        }
    }

    public function deactivate()
    {
        try {
            if ($this->database->are_tables_created()) {
                // Delete all data and drop the table
                $this->database->delete_all_data()->drop_tables();
            }
        } catch (\Exception $e) {
            // Log the error but don't stop deactivation
            error_log(PLUGIN_NAME . ' deactivation error: ' . $e->getMessage());
        }
    }

    public function get_admin()
    {
        return $this->admin;
    }

    public function get_database()
    {
        return $this->database;
    }
}
