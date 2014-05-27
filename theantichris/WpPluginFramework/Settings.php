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
    /** @var string The WordPress page slug the settings will appear on. */
    private $page;
    /** @var SettingsSection */
    private $settingsSection;
    /** @var SettingsField|SettingsField[] */
    private $settingsFields;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param SettingsArg $settingsArg
     */
    public function __construct(SettingsArg $settingsArg)
    {
        $this->page            = $settingsArg->getPageSlug();
        $this->settingsSection = $settingsArg->getSettingsSection();
        $this->settingsFields  = $settingsArg->getSettingsFields();

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
        add_settings_section($this->settingsSection->getId(), $this->settingsSection->getTitle(), array($this->settingsSection, 'displaySection'), $this->page);
    }

    /**
     * @since 1.2.0
     * @return void
     */
    private function registerFields()
    {
        if (is_array($this->settingsFields)) {
            foreach ($this->settingsFields as $field) {
                $this->registerField($field);
            }
        } else {
            $this->registerField($this->settingsFields);
        }
    }

    /**
     * @since 1.2.0
     * @param SettingsField $field
     * @return void
     */
    private function registerField($field)
    {
        $page = $this->page;
        $sectionId = $this->settingsSection->getId();

        add_action(
            'admin_init', function () use ($field, $page, $sectionId) {
                /** @noinspection PhpVoidFunctionResultUsedInspection */
                add_settings_field($field->getID(), $field->getTitle(), array($field, 'display'), $page, $sectionId, $field->getArgs());

                register_setting($page, $field->getID());
            }
        );
    }
}
