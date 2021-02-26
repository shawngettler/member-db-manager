<?php

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

}

?>
