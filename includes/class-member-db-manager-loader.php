<?php

/**
 * Registers the action and filter hooks with the WordPress API.
 */
class Member_DB_Manager_Loader {

    // actions and filters
    protected $actions;
    protected $filters;

    /**
     * Create hook arrays.
     */
    public function __construct() {
        $this->actions = array();
        $this->filters = array();
    }


    /**
     * Add an action to the list of hooks to be registered by the loader.
     *
     * @param string $hook name of the WordPress hook
     * @param object $component object where the callback is defined
     * @param string $callback name of the function
     * @param int $priority callback priority
     * @param int $nargs number of arguments passed to the callback
     */
    public function load_action($hook, $component, $callback, $priority = 10, $nargs = 1) {
        $this->actions[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'nargs' => $nargs
        );
    }

    /**
     * Add a filter to the list of hooks to be registered by the loader.
     *
     * @param string $hook name of the WordPress hook
     * @param object $component object where the callback is defined
     * @param string $callback name of the function
     * @param int $priority (optional) callback priority
     * @param int $nargs (optional) number of arguments passed to the callback
     */
    public function load_filter($hook, $component, $callback, $priority = 10, $nargs = 1) {
        $this->filters[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'nargs' => $nargs
        );
    }

    /**
     * Register the actions and filters.
     */
    public function run() {
        foreach($this->actions as $h) {
            add_action($h['hook'], array($h['component'], $h['callback']), $h['priority'], $h['nargs']);
        }
        foreach($this->filters as $h) {
            add_filter($h['hook'], array($h['component'], $h['callback']), $h['priority'], $h['nargs']);
        }
    }

}

?>
