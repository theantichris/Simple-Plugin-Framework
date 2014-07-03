<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsField
 * @package theantichris\WpPluginFramework
 * @since 2.0.0
 */
class SettingsField extends WordPressObject
{
    /** @var string Title of the field. Used to generate the slug. */
    protected $name;
    /** @var View The View object responsible for rendering the field's HTML. */
    private $view;
    /** @var string An identifier that will be prefixed to the ID to prevent naming conflicts in the database. */
    private $prefix;
    /** @var mixed[] Additional arguments that are passed to the $callback function. */
    private $args;

    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the field. Used to generate the slug.
     * @param View $view The View object responsible for rendering the field's HTML.
     * @param string $prefix An identifier that will be prefixed to the ID to prevent naming conflicts in the database.
     * @param mixed[] $args Additional arguments that are passed to the $callback function.
     */
    public function __construct($name, View $view, $prefix = 'lwppfw', $args = array())
    {
        $this->prefix                 = $prefix;
        $this->name                   = $name;
        $this->args                   = $args;
        $this->args['label_for']      = $this->getSlug(); // Automatically adds a <label> to the field.
        $this->view                   = $view;
        $this->view->viewData['name'] = $this->name;
        $this->view->viewData['slug'] = $this->getSlug();
    }

    /**
     * Returns a the sanitized name appended with the prefix.
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function getSlug()
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
     * Should not be called directly. It is only public so WordPress can call it.
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