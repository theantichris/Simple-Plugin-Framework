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
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param $pageSlug
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

        // TODO: Register sections.

        add_action('admin_init', array($this, 'registerSections'));

        // TODO: Register fields.

        $this->registerFields();
    }

    /**
     * Adds SettingsSection to this Setting.
     *
     * @since 3.0.0
     *
     * @param SettingsSection $section
     * @return void
     */
    public function addSection(SettingsSection $section)
    {
        if (array_key_exists($section->getId(), $this->settingsSections)) {
            wp_die(__("A section with ID {$section->getId()} was already added to settings for the {$this->pageSlug} page.", $this->textDomain));
        } else {
            $this->settingsSections[$section->getId()] = $section;
        }
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
     * @since 2.0.0
     * @return void
     */
    private function registerFields()
    {
        if (is_array($this->settingsSections)) {
            /** @var SettingsSection $section */
            foreach ($this->settingsSections as $section) {
                $this->doFields($section->getId(), $section->getSettingsFields());
            }
        } else {
            $this->doFields($this->settingsSections->getId(), $this->settingsSections->getSettingsFields());
        }
    }

    /**
     * @since 3.0.0
     * @param string $sectionId
     * @param SettingsField|SettingsField[] $fields
     * @return void
     * TODO: Rename this with something better.
     */
    private function doFields($sectionId, $fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $this->registerField($sectionId, $field);
            }
        } else {
            $this->registerField($sectionId, $fields);
        }
    }

    /**
     * @since 2.0.0
     * @param string $sectionId
     * @param SettingsField $field
     * @return void
     */
    private function registerField($sectionId, $field)
    {
        $page = $this->page;

        add_action(
            'admin_init', function () use ($field, $page, $sectionId) {
                /** @noinspection PhpVoidFunctionResultUsedInspection */
                add_settings_field($field->getID(), $field->getTitle(), array($field, 'display'), $page, $sectionId, $field->getArgs());

                register_setting($page, $field->getID());
            }
        );
    }
}
