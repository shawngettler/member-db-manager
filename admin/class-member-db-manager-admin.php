<?php

/**
 * Admin interface class.
 */
class Member_DB_Manager_Admin {

    // record table
    private $member_list_table;


    /**
     * Initialize admin functions.
     */
    public function __construct() {
    }


    /**
     * Register Javascript dependencies.
     */
    public function enqueue_scripts() {
    }

    /**
     * Register CSS dependencies.
     */
    public function enqueue_styles() {
    }

    /**
     * Add the plugin to the WordPress top-level menu. Run any initial
     * checks that may require a reload, then add the admin page.
     */
    public function add_admin_menu() {
        // prepare the record table
        require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
        require_once 'class-member-db-manager-admin-member-list-table.php';
        $this->member_list_table = new Member_DB_Manager_Admin_Member_List_Table();
        $this->member_list_table->prepare_items();

        add_menu_page('Member Database Manager', 'Member DB', 'manage_options', MEMBER_DB_MANAGER_PLUGIN_NAME, array($this, 'display_admin_page'));
    }

    /**
     * Display the admin page.
     */
    public function display_admin_page() {
        require_once 'partials/admin-show-records.php';
    }

}

?>
