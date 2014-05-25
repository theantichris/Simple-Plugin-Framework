<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsArg
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class SettingsArg
{
    /** @var string Slug of the page the settings will appear on. */
    private $pageSlug;
    /** @var SettingsSection */
    private $settingsSection;
    /** @var string */
    private $textDomain;

    /**
     * @since 1.2.0
     *
     * @param string $pageSlug
     * @param SettingsSection $settingsSection
     * @param string $textDomain
     */
    public function __construct($pageSlug, SettingsSection $settingsSection, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($page)) {
            wp_die(__('You did not specify a page for your settings.', $this->textDomain));
        } elseif (empty($settingsSection)) {
            wp_die(__('You did not specify a section for your settings.', $this->textDomain));
        } else {
            $this->pageSlug         = $pageSlug;
            $this->$settingsSection = $settingsSection;
        }
    }

    /**
     * @since 1.2.0
     * @return string
     */
    public function getPageSlug()
    {
        return $this->pageSlug;
    }

    /**
     * @since 1.2.0
     * @return mixed[]
     */
    public function getSettingsSection()
    {
        return $this->$settingsSection;
    }
} 