<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsField
 * @package theantichris\WpPluginFramework
 * @since 2.0.0
 */
class SettingsField extends WordPressObject
{
    /** @var string Title of the field. Used to generate the ID. */
    protected $name;
    /** @var View The View object responsible for rendering the field's HTML. */
    private $view;
    /** @var mixed[] Additional arguments that are passed to the $callback function. */
    private $args;
    /** @var string An identifier that will be prefixed to the ID to prevent naming conflicts in the database. */
    private $prefix;

    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the field. Used to generate the ID.
     * @param View $view The View object responsible for rendering the field's HTML.
     * @param string $prefix An identifier that will be prefixed to the ID to prevent naming conflicts in the database.
     * @param mixed[] $args Additional arguments that are passed to the $callback function.
     */
    public function __construct($name, View $view, $prefix = 'lwppfw', $args = array())
    {
        $this->prefix                  = $prefix;
        $this->name                    = $name;
        $this->args                    = $args;
        $this->view                    = $view;
        $this->view->viewData['title'] = $this->name;
        $this->view->viewData['id']    = $this->getID();
    }

    /**
     * Returns a the sanitized name appended with the prefix.
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function getID()
    {
        return $this->prefix . '-' . sanitize_title($this->name);
    }

    /**
     * Returns $args.
     *
     * @since 2.0.0
     *
     * @return mixed[]
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Renders the fields' view.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function display()
    {
        $this->view->render();
    }
} 