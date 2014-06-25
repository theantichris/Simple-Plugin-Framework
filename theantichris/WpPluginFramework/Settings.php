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
    private $page;
    /** @var SettingsSection|SettingsSection[] */
    private $settingsSections;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param SettingsArg $settingsArg
     */
    public function __construct(SettingsArg $settingsArg)
    {
        $this->page             = $settingsArg->getPageSlug();
        $this->settingsSections = $settingsArg->getSettingsSections();

        add_action('admin_init', array($this, 'registerSection'));

        $this->registerFields();
    }

    /**
     * Registers the settings section with WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerSection()
    {
        if (is_array($this->settingsSections)) {
            /** @var SettingsSection $section */
            foreach ($this->settingsSections as $section) {
                add_settings_section($section->getId(), $section->getTitle(), array($section, 'display'), $this->page);
            }
        } else {
            add_settings_section($this->settingsSections->getId(), $this->settingsSections->getTitle(), array($this->settingsSections, 'display'), $this->page);
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
