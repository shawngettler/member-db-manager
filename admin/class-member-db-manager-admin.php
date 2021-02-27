<?php

/**
 * Admin interface class.
 */
class Member_DB_Manager_Admin {

    // plugin version
    private $plugin_name;
    private $plugin_version;


    /**
     * Initialize admin functions.
     *
     * @param string $plugin_name plugin name
     * @param string $plugin_version plugin version
     */
    public function __construct($plugin_name, $plugin_version) {
        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;
    }


    /**
     * Register Javascript dependencies.
     */
    public function enqueue_scripts() {
    }

    /**
     * Add the plugin to the WordPress top-level menu.
     */
    public function add_admin_menu() {
        add_menu_page('Member Database Manager', 'Member DB', 'manage_options', $this->plugin_name, array($this, 'display_admin_page'));
    }

    /**
     * Display the default admin page.
     */
    public function display_admin_page() {
        require_once 'partials/admin_page.php';
    }

}

?>
