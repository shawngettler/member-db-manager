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
            'cb' => '<input type="checkbox" name="member[]" />',
            'edit' => '',
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
     * Table display for checkbox column.
     *
     * @param object $item database record
     */
    public function column_cb($item) {
        echo '<input id="cb-select-'.$item->id.'" type="checkbox" name="member[]" value="'.$item->id.'" />';
    }

    /**
     * Table display for edit button column.
     *
     * @param object $item database record
     */
    public function column_edit($item) {
        $actions = array(
            'edit' => '<a href="?page=member-db-manager&view=edit&member='.$item->id.'"><span class="dashicons dashicons-edit"></span></a>'
        );
        echo $this->row_actions($actions);
    }

    /**
     * Override prepare. Query the database for items to display.
     */
    public function prepare_items() {
        global $wpdb;
        $plugin_options = get_option(MEMBER_DB_MANAGER_OPTION);

        $table_name = $wpdb->prefix.$plugin_options['db_name'];

        // search terms
        $qsearch = '';
        if(isset($_GET['s']) && !empty($_GET['s'])) {
            $searchterms = explode(' ', $_GET['s']);
            $searchcols = array('email', 'firstname', 'lastname');
            foreach($searchterms as $s) {
                foreach($searchcols as $c) {
                    $qsearch .= $qsearch === '' ? ' WHERE ' : ' OR ';
                    $qsearch .= $wpdb->prepare($c.' LIKE %s', '%'.$wpdb->esc_like($s).'%');
                }
            }
        }

        // pagination
        $qcount = 'SELECT COUNT(id) FROM '.$table_name;
        $items_count = $wpdb->get_var($qcount.$qsearch);

        $items_page = $this->get_pagenum();
        $items_per_page = $plugin_options['items_per_page'];
        $this->set_pagination_args(array('total_items' => $items_count, 'per_page' => $items_per_page));

        $qlimit = '';
        if($items_per_page > $items_count) {
            $qlimit = ' LIMIT '.($items_page-1)*$items_per_page.', '.$items_per_page;
        }

        // order
        $qorder = '';
        if(isset($_GET['orderby']) && array_key_exists($_GET['orderby'], $this->get_sortable_columns())) {
            $qorder = ' ORDER BY '.$_GET['orderby'].' '.$_GET['order'];
        }

        // query
        $qselect = 'SELECT * FROM '.$table_name;
        $this->items = $wpdb->get_results($qselect.$qsearch.$qorder.$qlimit);
    }

}

?>
