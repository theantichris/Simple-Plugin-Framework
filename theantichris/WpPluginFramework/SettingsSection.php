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
    /** @var string */
    private $textDomain;
    /** @var SettingsField[] */
    private $settingsFields = array();

    /**
     * @since 2.0.0
     * @param string $title
     * @param View $view
     * @param string $textDomain
     */
    public function __construct($title, $view, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($title)) {
            wp_die(__('You did not specify a title for your settings section.', $this->textDomain));
        } elseif (empty($view)) {
            wp_die(__("You did not specify a view for settings section {$title}.", $this->textDomain));
        } else {
            $this->title                   = $title;
            $this->view                    = $view;
            $this->view->viewData['title'] = $this->title;
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
     * @since 2.0.0
     * @return void
     */
    public function display()
    {
        $this->view->render();
    }

    /**
     * Adds a SettingsField to this SettingsSection if it does not already exist.
     *
     * @since 3.0.0
     *
     * @param SettingsField $field
     * @return $this
     */
    public function addField(SettingsField $field)
    {
        if (array_key_exists($field->getId(), $this->settingsFields)) {
            wp_die(__("A section with ID {$field->getId()} was already added to the settings section {$this->getId()} page.", $this->textDomain));
        } else {
            $this->settingsFields[$field->getId()] = $field;
        }

        return $this;
    }
} 