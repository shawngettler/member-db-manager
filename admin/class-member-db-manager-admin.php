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
        wp_enqueue_style('member-list-table-style', plugin_dir_url(__FILE__).'css/member-list-table-style.css');
    }

    /**
     * Add the plugin to the WordPress top-level menu. Run any initial
     * checks that may require a reload, then add the admin page.
     */
    public function add_admin_menu() {
        // clean up get
        if(!empty($_GET['_wp_http_referer'])) {
            wp_redirect(remove_query_arg(array('_wp_http_referer', '_wpnonce' ), wp_unslash($_SERVER['REQUEST_URI'])));
        }

        // prepare the record table
        require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
        require_once 'class-member-db-manager-admin-member-list-table.php';
        $this->member_list_table = new Member_DB_Manager_Admin_Member_List_Table();
        $this->member_list_table->prepare_items();

        // add page
        add_menu_page('Member Database Manager', 'Member DB', 'manage_options', MEMBER_DB_MANAGER_PLUGIN_NAME, array($this, 'display_admin_page'), 'dashicons-database');
    }

    /**
     * Display the admin page.
     */
    public function display_admin_page() {
        require_once 'partials/admin-show-records.php';
    }

}

?>
