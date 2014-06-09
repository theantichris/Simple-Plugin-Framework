<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsArg
 * @package theantichris\WpPluginFramework
 * @since 2.0.0
 */
class SettingsArg
{
    /** @var string Slug of the page the settings will appear on. */
    private $pageSlug;
    /** @var SettingsSection */
    private $settingsSection;
    /** @var SettingsField|SettingsField[] */
    private $settingsFields;
    /** @var string */
    private $textDomain;

    /**
     * @since 2.0.0
     *
     * @param string $pageSlug
     * @param SettingsSection $settingsSection
     * @param SettingsField|SettingsField[] $settingsFields
     * @param string $textDomain
     */
    public function __construct($pageSlug, SettingsSection $settingsSection, $settingsFields, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($pageSlug)) {
            wp_die(__('You did not specify a page for your settings.', $this->textDomain));
        } elseif (empty($settingsSection)) {
            wp_die(__('You did not specify a section for your settings.', $this->textDomain));
        } elseif (empty($settingsFields)) {
            wp_die(__('You did not specify any fields for your settings.', $this->textDomain));
        } else {
            $this->pageSlug        = $pageSlug;
            $this->settingsSection = $settingsSection;
            $this->settingsFields  = $settingsFields;
        }
    }

    /**
     * @since 2.0.0
     * @return string
     */
    public function getPageSlug()
    {
        return $this->pageSlug;
    }

    /**
     * @since 2.0.0
     * @return mixed[]
     */
    public function getSettingsSection()
    {
        return $this->settingsSection;
    }

    /**
     * @since 2.0.0
     * @return SettingsField|SettingsField[]
     */
    public function getSettingsFields()
    {
        return $this->settingsFields;
    }
}