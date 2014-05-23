<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsArg
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class SettingsArg
{
    /** @var string */
    private $page = 'general';
    /** @var mixed[] */
    private $sectionInfo;

    public function __construct($page, $sectionInfo, $textDomain = '')
    {
        if (empty($page)) {
            wp_die(__('You did not specify a page for your settings.', $textDomain));
        } else {
            $this->page    = $page;
            $this->$sectionInfo = $this->setSection();
        }
    }

    private function setSection()
    {
        return array(
            'title'    => 'My Settings',
            'id'       => 'my-settings',
            'viewPath' => null,
            'viewData' => array(),
        );
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getSectionInfo()
    {
        return $this->$sectionInfo;
    }
} 