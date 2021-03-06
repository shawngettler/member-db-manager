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
     * Override columns to be displayed.
     */
    public function get_columns() {
        return array(
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'street' => 'Address',
            'city' => 'City',
            'province' => 'Prov',
            'country' => 'Country',
            'postalcode' => 'Postal Code',
            'membertype' => 'Membership',
            'createdate' => 'Joined',
            'updatedate' => 'Renewed',
            'expiredate' => 'Expires'
        );
    }

    /**
     * Override sortable columns.
     */
    public function get_sortable_columns() {
        return array(
            'createdate' => array('createdate', true),
            'updatedate' => array('updatedate', true),
            'expiredate' => array('expiredate', true)
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
     * Override prepare. Query the database for items to display.
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
        $q = 'SELECT * FROM '.$table_name;
        if(isset($_GET['s']) && !empty($_GET['s'])) {
            $qsearch = sanitize_text_field($_GET['s']);
            $q .= $wpdb->prepare(' WHERE email LIKE %s', '%'.$wpdb->esc_like($qsearch).'%');
            $q .= $wpdb->prepare(' OR firstname LIKE %s', '%'.$wpdb->esc_like($qsearch).'%');
            $q .= $wpdb->prepare(' OR lastname LIKE %s', '%'.$wpdb->esc_like($qsearch).'%');
        }
        if(isset($_GET['orderby']) && array_key_exists($_GET['orderby'], $this->get_sortable_columns())) {
            $qorderby = $_GET['orderby'];
            $qorder = $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
            $q .= ' ORDER BY '.$qorderby.' '.$qorder;
        }
        $q .= ' LIMIT '.($items_page-1)*$items_per_page.', '.$items_per_page;

        $this->items = $wpdb->get_results($q);
    }

}

?>
