<?php

/**
 * Core plugin class.
 */
class Member_DB_Manager {

    // plugin version
    protected $plugin_name;
    protected $plugin_version;

    // hook loader
    protected $loader;


    /**
     * Load dependencies and set hooks for the plugin interface.
     */
    public function __construct() {
        $this->plugin_name = 'member-db-manager';
        $this->plugin_version = MEMBER_DB_MANAGER_VERSION;

        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-member-db-manager-loader.php';
        $this->loader = new Member_DB_Manager_Loader();

        $this->define_admin_hooks();
    }

    /**
     * Register hooks for the admin interface.
     */
    private function define_admin_hooks() {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-member-db-manager-admin.php';
        $plugin_admin = new Member_DB_Manager_Admin($this->plugin_name, $this->plugin_version);

        $this->loader->load_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
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
