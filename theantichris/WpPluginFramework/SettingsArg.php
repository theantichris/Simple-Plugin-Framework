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
    /** @var mixed[] */
    private $sectionInfo;
    /** @var string */
    private $textDomain;

    /**
     * @since 1.2.0
     *
     * @param string $pageSlug
     * @param null $sectionInfo
     * @param string $textDomain
     */
    public function __construct($pageSlug = 'general', $sectionInfo = null, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($page)) {
            wp_die(__('You did not specify a page for your settings.', $this->textDomain));
        } else {
            $this->pageSlug     = $pageSlug;
            $this->$sectionInfo = $this->setSection($sectionInfo);
        }
    }

    /**
     * @since 1.2.0
     *
     * @param mixed[] $sectionInfo
     * @return mixed[]
     */
    private function setSection($sectionInfo)
    {
        if (empty($sectionInfo)) {
            return array(
                'title'    => __('My Settings', $this->textDomain),
                'id'       => 'my-settings',
                'viewPath' => null,
                'viewData' => array(),
            );
        }

        return $sectionInfo;
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
    public function getSectionInfo()
    {
        return $this->$sectionInfo;
    }
} 