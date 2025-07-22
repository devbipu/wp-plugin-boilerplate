<?php

namespace Devbipu\WpPluginBoilerplate;

class Database
{
  private static $instance = null;
  private $tables_created = false;

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Check if the providers table exists
   * 
   * @return bool
   */
  private function table_exists()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'your-table-name';
    return $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
  }

  /**
   * Create database tables
   * 
   * @return self
   * @throws \Exception If tables already exist
   */
  public function create_tables()
  {
    if ($this->table_exists()) {
      throw new \Exception('Database tables already exist');
    }

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}'your-table-name' (
    //         id bigint(20) NOT NULL AUTO_INCREMENT,
    //         name varchar(100) NOT NULL,
    //         class_name varchar(100) NOT NULL,
    //         api_key varchar(255) NOT NULL,
    //         api_secret varchar(255) DEFAULT NULL,
    //         network_id varchar(100) DEFAULT NULL,
    //         is_active tinyint(1) NOT NULL DEFAULT 0,
    //         created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    //         updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //         PRIMARY KEY  (id)
    //     ) $charset_collate;";

    // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    // dbDelta($sql);

    // $this->tables_created = true;
    return $this;
  }

  /**
   * Insert default providers
   * 
   * @return self
   * @throws \Exception If tables don't exist
   */
  public function insert_default_data()
  {
    if (!$this->table_exists()) {
      throw new \Exception('Database tables must be created before inserting default providers');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'your-table-name';

    $default_data = [
      ['your_column' => 'Data']
    ];

    foreach ($default_data as $data) {
      // $exists = $wpdb->get_var($wpdb->prepare(
      //   "SELECT COUNT(*) FROM $table_name WHERE 1"
      // ));

      // if (!$exists) {
      //   $wpdb->insert($table_name, $data);
      // }
    }

    return $this;
  }



  /**
   * Delete all data from the providers table
   * 
   * @return self
   * @throws \Exception If tables don't exist
   */
  public function delete_all_data()
  {
    if (!$this->table_exists()) {
      throw new \Exception('Database tables must be created before deleting data');
    }

    global $wpdb;
    // $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}your-table-name");
    return $this;
  }

  /**
   * Drop the providers table
   * 
   * @return self
   * @throws \Exception If tables don't exist
   */
  public function drop_tables()
  {
    if (!$this->table_exists()) {
      throw new \Exception('Database tables must be created before dropping them');
    }

    global $wpdb;
    // $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}your-table-name");
    $this->tables_created = false;
    return $this;
  }

  /**
   * Check if tables are created
   * 
   * @return bool
   */
  public function are_tables_created()
  {
    return $this->table_exists();
  }
}
