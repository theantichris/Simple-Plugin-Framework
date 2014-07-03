<?php

namespace theantichris\WpPluginFramework;

/**
 * Class DashboardWidget
 * @package theantichris\WpPluginFramework
 * @since 3.0.0
 */
class DashboardWidget extends WordPressObject
{
    /** @var string The name your widget will display in its heading. */
    private $name;
    /** @var View The View object responsible for displaying the widget. */
    private $view;

    /**
     * Assigns properties, sets name and slug in the View's $viewData, and ties the addWidget() method to the wp_dashboard_setup hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/wp_dashboard_setup
     *
     * @since 3.0.0
     *
     * @param string $name The name your widget will display in its heading.
     * @param View $view The View object responsible for displaying the widget.
     */
    public function __construct($name, View $view)
    {
        $this->name                   = $name;
        $this->view                   = $view;
        $this->view->viewData['name'] = $this->name;
        $this->view->viewData['slug'] = $this->getSlug();

        add_action('wp_dashboard_setup', array($this, 'addWidget'));
    }
}