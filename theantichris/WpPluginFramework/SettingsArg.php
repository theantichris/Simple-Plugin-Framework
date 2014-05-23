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

    private function setSection($sectionInfo)
    {
        if (empty($sectionInfo)) {
            return array(
                'title'    => 'My Settings',
                'id'       => 'my-settings',
                'viewPath' => null,
                'viewData' => array(),
            );
        }

        return $sectionInfo;
    }

    public function getPageSlug()
    {
        return $this->pageSlug;
    }

    public function getSectionInfo()
    {
        return $this->$sectionInfo;
    }
} 