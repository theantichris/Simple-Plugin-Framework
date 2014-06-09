<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsField
 * @package theantichris\WpPluginFramework
 * @since 2.0.0
 */
class SettingsField
{
    /** @var  string */
    private $title;
    /** @var View */
    private $view;
    /** @var  mixed[] */
    private $args;
    /** @var  string */
    private $prefix;

    /**
     * @since 2.0.0
     * @param string $title
     * @param View $view
     * @param mixed[] $args
     * @param string $prefix
     * @param string $textDomain
     */
    public function __construct($title, View $view, $args = array(), $prefix = 'lwppfw', $textDomain = '')
    {
        if (empty($title)) {
            wp_die(__('You did not specify a title for your settings field.', $textDomain));
        } elseif (empty($view)) {
            wp_die(__('You did not specify a view for your settings field.', $textDomain));
        } else {
            $this->title                   = $title;
            $this->view                    = $view;
            $this->view->viewData['title'] = $this->title;
            $this->args                    = $args;
            $this->prefix                  = $prefix;
        }
    }

    /**
     * @since 2.0.0
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @since 2.0.0
     * @return string
     */
    public function getID()
    {
        return $this->prefix . '-' . sanitize_title($this->title);
    }

    /**
     * @since 2.0.0
     * @return mixed[]
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @since 2.0.0
     * @return void
     */
    public function display()
    {
        $this->view->render();
    }
} 