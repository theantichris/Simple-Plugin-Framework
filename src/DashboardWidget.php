<?php

namespace theantichris\spf;

/**
 * Class DashboardWidget
 * @link http://codex.wordpress.org/Dashboard_Widgets_API
 *
 * @package theantichris\spf
 * @since 3.0.0
 */
class DashboardWidget extends WordPressObject
{
    /** @var string The name your widget will display in its heading. */
    protected $name;
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

    /**
     * Displays the widget's HTML.
     * Should not be called directly. It is only public so WordPress can call it.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function display()
    {
        $this->view->render();
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