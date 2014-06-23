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
    /** @var SettingsSection|SettingsSection[] */
    private $settingsSections;
    /** @var string */
    private $textDomain;

    /**
     * @since 2.0.0
     *
     * @param string $pageSlug
     * @param SettingsSection|SettingsSection[] $settingsSections
     * @param string $textDomain
     */
    public function __construct($pageSlug, $settingsSections, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($pageSlug)) {
            wp_die(__('You did not specify a page for your settings.', $this->textDomain));
        } elseif (empty($settingsSections)) {
            wp_die(__('You did not specify any sections for your settings.', $this->textDomain));
        } else {
            $this->pageSlug        = $pageSlug;
            $this->settingsSection = $settingsSections;
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
    public function getSettingsSections()
    {
        return $this->settingsSections;
    }
}