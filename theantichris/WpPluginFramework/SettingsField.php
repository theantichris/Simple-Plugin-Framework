<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsField
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
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

    /**
     * @since 1.2.0
     * @param string $title
     * @param View $view
     * @param mixed[] $args
     * @param string $textDomain
     */
    public function __construct($title, View $view, $args = array(), $textDomain = '')
    {
        if (empty($title)) {
            wp_die(__('You did not specify a title for your settings field.', $textDomain));
        } elseif (empty($view)) {
            wp_die(__('You did not specify a view for your settings field.', $textDomain));
        } else {
            $this->title                    = $title;
            $this->view                     = $view;
            $this->view->view_data['title'] = $this->title;
            $this->args                     = $args;
        }
    }

    /**
     * @since 1.2.0
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @since 1.2.0
     * @return string
     */
    public function getID()
    {
        return sanitize_title($this->title);
    }

    /**
     * @since 1.2.0
     * @return mixed[]
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @since 1.2.0
     * @return void
     */
    public function display()
    {
        echo $this->view->render();
    }
} 