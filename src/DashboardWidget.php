<?php

namespace theantichris\SPF;

/**
 * Class DashboardWidget
 * @link http://codex.wordpress.org/Dashboard_Widgets_API
 *
 * @package theantichris\SPF
 * @since 3.0.0
 */
class DashboardWidget extends WordPressObject
{
    /**
     * Assigns properties, sets name and slug in the View's $viewData, and ties the addWidget() method to the wp_dashboard_setup hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/wp_dashboard_setup
     *
     * @since 3.0.0
     *
     * @param string $name The name your widget will display in its heading.
     * @param string $viewFile The full path to the object's view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    public function __construct($name, $viewFile, $viewData = array())
    {
        $this->name             = $name;
        $this->viewFile         = $viewFile;
        $this->viewData         = $viewData;
        $this->viewData['name'] = $this->getName();
        $this->viewData['slug'] = $this->getSlug();

        add_action('wp_dashboard_setup', array($this, 'addWidget'));
    }

    /**
     * Calls the WordPress function wp_add_dashboard_widget().
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addWidget()
    {
        wp_add_dashboard_widget($this->getSlug(), $this->getName(), array($this, 'display'));
    }
}