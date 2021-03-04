<?php

/**
 * Utility class for plugin activation.
 */
class Member_DB_Manager_Activator {


    /**
     * Activate the plugin. Check for existing options and tables and try
     * to upgrade them to the current plugin version.
     */
    public static function activate() {

        // check options
        $option_name = MEMBER_DB_MANAGER_OPTION;
        $plugin_options = get_option($option_name);
        if(!$plugin_options) {
            $plugin_options = Member_DB_Manager::$default_options;
            add_option($option_name, $plugin_options);

        } else {
            error_log('Plugin option '.$option_name.' aleady exists.');
            // upgrade from old plugin version as required
        }

        // check tables
        global $wpdb;
        $table_name = $wpdb->prefix.$plugin_options['db_name'];
        if($wpdb->get_var('SHOW TABLES LIKE \''.$table_name.'\'') != $table_name) {
            $table_schema = implode(', ', Member_DB_Manager::$default_schema);
            $table_charset = $wpdb->get_charset_collate();
            $wpdb->query('CREATE TABLE '.$table_name.' ( '.$table_schema.' ) '.$table_charset);

        } else {
            error_log('Plugin table '.$table_name.' already exists.');
            // upgrade from old plugin version as required
        }
    }

}

?>
