<?php

namespace theantichris\SPF;

/**
 * Class Settings
 *
 * A class for creating and managing settings in WordPress.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class Settings extends WordPressObject
{
    /** @var string The slug of the page the settings will appear on. */
    private $pageSlug;
    /** @var SettingsSection[] */
    private $settingsSections = array();

    /**
     * Sets page slug and text domain for the object.
     * Adds the registerSection() and registerFields() methods to the admin_init action hook in WordPress.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
     *
     * @since 0.1.0
     *
     * @param string $pageSlug The slug of the page the settings will appear on.
     */
    public function __construct($pageSlug)
    {
        $this->pageSlug = $pageSlug;

        add_action('admin_init', array($this, 'registerSections'));
        add_action('admin_init', array($this, 'registerFields'));
    }


    /**
     * Sends SettingsSection objects to addSection().
     *
     * @since 3.0.0
     *
     * @param SettingsSection|SettingsSection[] $sections
     * @return $this
     */
    public function addSections($sections)
    {
        if (is_array($sections)) {
            /** @var SettingsSection $section */
            foreach ($sections as $section) {
                $this->addSection($section);
            }
        } else {
            $this->addSection($sections);
        }

        return $this;
    }

    /**
     * Adds a SettingsSection to this Setting. Checks if it already exists.
     *
     * @since 3.0.0
     *
     * @param SettingsSection $section
     * @return Settings
     */
    private function addSection(SettingsSection $section)
    {
        if (array_key_exists($section->getSlug(), $this->settingsSections)) {
            wp_die(__("A section with ID {$section->getSlug()} was already added to the settings for the {$this->pageSlug} page.", parent::$textDomain));
        } else {
            $this->settingsSections[$section->getSlug()] = $section;
        }

        return $this;
    }

    /**
     * Calls the WordPress function add_settings_section() for each SettingSection attached to this Setting.     *
     * Do not call this function directly, it is tied to the admin_init hook in WordPress.     *
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
            add_settings_section($section->getSlug(), $section->getName(), array($section, 'display'), $this->pageSlug);
        }
    }

    /**
     * Calls the WordPress functions add_settings_field() and register_setting() for each SettingsField attached to each SettingsSection.     *
     * Do not call this function directly, it is tied to the admin_init hook in WordPress.     *
     * @link http://codex.wordpress.org/Function_Reference/add_settings_field
     * @link http://codex.wordpress.org/Function_Reference/register_setting
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function registerFields()
    {
        /** @var SettingsSection $section */
        foreach ($this->settingsSections as $section) {
            /** @var SettingsField[] $fields */
            $fields = $section->getFields();

            /** @var SettingsField $field */
            foreach ($fields as $field) {
                add_settings_field($field->getSlug(), $field->getName(), array($field, 'display'), $this->pageSlug, $section->getSlug());

                register_setting($this->pageSlug, $field->getSlug());
            }
        }
    }
}
