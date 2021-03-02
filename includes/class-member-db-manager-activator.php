<?php

/**
 * Utility class for plugin activation.
 */
class Member_DB_Manager_Activator {

    // defaults
    public static $default_options = array(
        'version' => MEMBER_DB_MANAGER_VERSION,
        'db_name' => 'Member List'
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
     * Activate the plugin. Check for existing options and tables and try
     * to upgrade them to the current plugin version.
     */
    public static function activate() {

        // check options
        $option_name = 'member_db_manager_option';
        $plugin_options = get_option($option_name);
        if(!$plugin_options) {
            $plugin_options = Member_DB_Manager_Activator::$default_options;
            add_option($option_name, $plugin_options);

        } else {
            error_log('Plugin option '.$option_name.' aleady exists.');
            // upgrade from old plugin version as required
        }

        // check tables
        global $wpdb;
        $table_name = $wpdb->prefix.'member_db_manager_data';
        if($wpdb->get_var('SHOW TABLES LIKE \''.$table_name.'\'') != $table_name) {
            $table_schema = implode(', ', Member_DB_Manager_Activator::$default_schema);
            $table_charset = $wpdb->get_charset_collate();
            $wpdb->query('CREATE TABLE '.$table_name.' ( '.$table_schema.' ) '.$table_charset);

        } else {
            error_log('Plugin table '.$table_name.' already exists.');
            // upgrade from old plugin version as required
        }
    }

}

?>
