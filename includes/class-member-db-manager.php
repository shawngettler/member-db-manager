<?php

/**
 * Core plugin class.
 */
class Member_DB_Manager {

    // hook loader
    protected $loader;


    // defaults
    public static $default_options = array(
        'version' => MEMBER_DB_MANAGER_VERSION,
        'db_name' => 'member_db_manager_data',
        'items_per_page' => 20
    );
    public static $default_schema = array(
        'id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'hid SMALLINT UNSIGNED',
        'membertype TINYINT UNSIGNED NOT NULL',
        'memberterm TINYINT UNSIGNED NOT NULL',
        'createdate DATE NOT NULL',
        'updatedate DATE NOT NULL',
        'expiredate DATE NOT NULL',
        'firstname VARCHAR(32) NOT NULL',
        'lastname VARCHAR(32) NOT NULL',
        'email VARCHAR(64) NOT NULL',
        'street VARCHAR(128) NOT NULL',
        'city VARCHAR(32) NOT NULL',
        'province CHAR(2) NOT NULL',
        'country VARCHAR(32) NOT NULL',
        'postalcode CHAR(6) NOT NULL',
        'phone CHAR(10)',
        'message VARCHAR(256)',
        'hearabout TINYINT'
    );


    /**
     * Load dependencies and set hooks for the plugin interface.
     */
    public function __construct() {
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-member-db-manager-loader.php';
        $this->loader = new Member_DB_Manager_Loader();

        $this->define_admin_hooks();
    }

    /**
     * Register hooks for the admin interface.
     */
    private function define_admin_hooks() {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-member-db-manager-admin.php';
        $plugin_admin = new Member_DB_Manager_Admin();

        $this->loader->load_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->load_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->load_action('admin_menu', $plugin_admin, 'add_admin_menu');
    }

    /**
     * Run the loader.
     */
    public function run() {
        $this->loader->run();
    }

}

?>
