<?php

namespace theantichris\SPF;

class WelcomePanel extends WordPressObject
{
    /**
     * Sets properties and replaces the default WordPress welcome panel with itself.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/welcome_panel
     *
     * @since 3.0.0
     *
     * @param string $viewFile The full path to the view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    public function __construct($viewFile, $viewData = array())
    {
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;

        remove_action('welcome_panel', 'wp_welcome_panel');
        add_action('welcome_panel', array($this, 'display'));
    }
}