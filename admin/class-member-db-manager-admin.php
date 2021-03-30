<?php

/**
 * Admin interface class.
 */
class Member_DB_Manager_Admin {

    // views
    private $admin_view_default;
    private $admin_view_page;

    // record table
    private $member_list_table;

    // edit form
    private $member_form;


    /**
     * Initialize admin functions.
     */
    public function __construct() {
        $this->admin_view_default = 'show';
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
        wp_enqueue_style('member-form-style', plugin_dir_url(__FILE__).'css/member-form-style.css');
    }

    /**
     * Add the plugin to the WordPress top-level menu.
     */
    public function add_admin_menu() {
        add_menu_page('Member Database Manager', 'Member DB', 'manage_options', MEMBER_DB_MANAGER_PLUGIN_NAME, array($this, 'display_admin_page'), 'dashicons-database');
    }

    /**
     * Initialize the admin page.
     */
    public function init_admin_page() {
        if(isset($_GET['view']) && !empty($_GET['view'])) {

            // show db record table
            if($_GET['view'] === 'show') {
                if(!empty($_GET['_wp_http_referer'])) {
                    wp_redirect(remove_query_arg(array('_wp_http_referer', '_wpnonce')));
                }
                require_once 'class-member-db-manager-admin-member-list-table.php';
                $this->member_list_table = new Member_DB_Manager_Admin_Member_List_Table();
                $this->member_list_table->prepare_items();

                $this->admin_view_page = 'partials/admin-show-records.php';

            // edit db records
            } else if($_GET['view'] === 'edit') {
                require_once 'class-member-db-manager-admin-member-form.php';
                $this->member_form = new Member_DB_Manager_Admin_Member_Form();

                if(isset($_POST['action'])) {
                    $this->member_form->process();
                } else {
                    $this->member_form->prepare();
                }

                $this->admin_view_page = 'partials/admin-edit-records.php';
            }

        // redirect to default view
        } else {
            wp_redirect(add_query_arg('view', $this->admin_view_default));
        }
    }

    /**
     * Display the admin page.
     */
    public function display_admin_page() {
        require_once $this->admin_view_page;
    }

}

?>
