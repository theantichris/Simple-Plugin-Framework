<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsSection
 * @package theantichris\WpPluginFramework
 * @since 2.0.0
 */
class SettingsSection
{
    /** @var string */
    private $title;
    /** @var View */
    private $view;
    /** @var SettingsField|SettingsField[] */
    private $settingsFields;

    /**
     * @since 2.0.0
     * @param string $title
     * @param View $view
     * @param SettingsField|SettingsField[] $settingsFields
     * @param string $textDomain
     */
    public function __construct($title, $view, $settingsFields, $textDomain = '')
    {
        if (empty($title)) {
            wp_die(__('You did not specify a title for your settings section.', $textDomain));
        } elseif (empty($view)) {
            wp_die(__('You did not specify a view for your settings section.', $textDomain));
        } else {
            $this->title                   = $title;
            $this->view                    = $view;
            $this->view->viewData['title'] = $this->title;
            $this->settingsFields          = $settingsFields;
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
    public function getId()
    {
        return sanitize_title($this->title);
    }

    /**
     * @since 3.0.0
     * @return SettingsField|SettingsField[]
     */
    public function getSettingsFields()
    {
        return $this->settingsFields;
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