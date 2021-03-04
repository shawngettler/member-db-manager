<?php

/**
 * Custom table class for displaying member records.
 */
class Member_DB_Manager_Admin_Member_List_Table extends WP_List_Table {


    /**
     * Override constructor.
     */
    public function __construct() {
        parent::__construct(array('plural' => 'members'));
    }


    /**
     * Define columns to be displayed.
     */
    public function get_columns() {
        return array(
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'createdate' => 'Joined',
            'updatedate' => 'Renewed',
            'expiredate' => 'Expires'
        );
    }

    /**
     * Define sortable columns.
     */
    public function get_sortable_columns() {
        return array(
            'createdate' => array('createdate', true),
            'expiredate' => 'expiredate'
        );
    }

    /**
     * Default table display for a column.
     *
     * @param object $item database record
     * @param string $column_name name of column
     */
    public function column_default($item, $column_name) {
        echo '<span>'.$item->$column_name.'</span>';
    }


    /**
     * Query the database for items to display.
     */
    public function prepare_items() {
        global $wpdb;
        $plugin_options = get_option(MEMBER_DB_MANAGER_OPTION);

        $table_name = $wpdb->prefix.$plugin_options['db_name'];

        // pagination
        $items_count = $wpdb->get_var('SELECT COUNT(id) FROM '.$table_name);
        $items_per_page = $plugin_options['items_per_page'];
        $items_page = $this->get_pagenum();
        $this->set_pagination_args(array('total_items' => $items_count, 'per_page' => $items_per_page));

        // column headers
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        // query
        $q = array(
            'SELECT * FROM '.$table_name,
            'LIMIT '.($items_page-1)*$items_per_page.', '.$items_per_page
        );
        $this->items = $wpdb->get_results(implode(' ', $q));
    }

}

?>
