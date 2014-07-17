<?php

namespace theantichris\SPF;

class WelcomePanel extends WordPressObject
{
    /** @var View The View object responsible for rendering the welcome panel's HTML. */
    private $view;

    /**
     * Sets properties and replaces the default WordPress welcome panel with itself.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/welcome_panel
     *
     * @since 3.0.0
     *
     * @param View $view The View object responsible for rendering the welcome panel's HTML.
     */
    public function __construct(View $view)
    {
        $this->view = $view;

        remove_action('welcome_panel', 'wp_welcome_panel');
        add_action('welcome_panel', array($view, 'render'));
    }
}