<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Settings
 *
 * A class for creating and managing settings in WordPress.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class Settings
{
    /** @var string The slug of the page the settings will appear on. */
    private $pageSlug;
    /** @var string */
    private $textDomain;
    /** @var SettingsSection[] */
    private $settingsSections = array();

    /**
     * Sets page slug and text domain for the object.
     * Adds the registerSection() and registerFields() methods to the admin_init action hook in WordPress.
     *
     * @since 0.1.0
     *
     * @param string $pageSlug
     * @param string $textDomain
     */
    public function __construct($pageSlug, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($pageSlug)) {
            wp_die(__('You did not specify a page slug for your settings.', $this->textDomain));
        } else {
            $this->pageSlug = $pageSlug;
        }

        add_action('admin_init', array($this, 'registerSections'));
        add_action('admin_init', array($this, 'registerFields'));
    }

    /**
     * Adds a SettingsSection to this Setting. Checks if it already exists.
     *
     * @since 3.0.0
     *
     * @param SettingsSection $section
     * @return Settings
     */
    public function addSection(SettingsSection $section)
    {
        if (array_key_exists($section->getId(), $this->settingsSections)) {
            wp_die(__("A section with ID {$section->getId()} was already added to the settings for the {$this->pageSlug} page.", $this->textDomain));
        } else {
            $this->settingsSections[$section->getId()] = $section;
        }

        return $this;
    }

    /**
     * Calls the WordPress function add_settings_section() for each SettingSection attached to this Setting.
     * @link http://codex.wordpress.org/Function_Reference/add_settings_section
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function registerSections()
    {
        /** @var SettingsSection $section */
        foreach ($this->settingsSections as $section) {
            add_settings_section($section->getId(), $section->getTitle(), array($section, 'display'), $this->pageSlug);
        }
    }

    /**
     * Calls the WordPress functions add_settings_field() and register_setting() for each SettingsField attached to each SettingsSection.
     * @link http://codex.wordpress.org/Function_Reference/add_settings_field
     * @link http://codex.wordpress.org/Function_Reference/register_setting
     *
     * @since 3.0.0
     */
    public function registerFields()
    {
        /** @var SettingsSection $section */
        foreach ($this->settingsSections as $section) {
            /** @var SettingsField[] $fields */
            $fields = $section->getFields();

            /** @var SettingsField $field */
            foreach ($fields as $field) {
                add_settings_field($field->getID(), $field->getTitle(), array($field, 'display'), $this->pageSlug, $section->getId(), $field->getArgs());

                register_setting($this->pageSlug, $field->getID());
            }
        }
    }
}
