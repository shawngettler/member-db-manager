<?php

/**
 * Plugin Name:       Member Database Manager
 * Plugin URI:        https://github.com/shawngettler/member-db-manager
 * Description:       Manage a membership database using a WordPress website.
 * Version:           0.1.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Shawn Gettler
 * Author URI:        https://github.com/shawngettler
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if(!defined('WPINC')) {
    die;
}


// plugin version
define('MEMBER_DB_MANAGER_VERSION', '0.1.0');


// plugin requires and activation/deactivation
require plugin_dir_path(__FILE__).'includes/class-member-db-manager.php';

function activate_member_db_manager() {
    require_once plugin_dir_path(__FILE__).'includes/class-member-db-manager-activator.php';
    Member_DB_Manager_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_member_db_manager');

function deactivate_member_db_manager() {
    require_once plugin_dir_path(__FILE__).'includes/class-member-db-manager-deactivator.php';
    Member_DB_Manager_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_member_db_manager');


// run plugin
function run_member_db_manager() {
    $plugin = new Member_DB_Manager();
    $plugin->run();
}
run_member_db_manager();


?>
