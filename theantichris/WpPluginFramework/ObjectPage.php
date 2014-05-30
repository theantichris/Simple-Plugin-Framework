<?php

namespace theantichris\WpPluginFramework;

/**
 * Class ObjectPage
 *
 * A class for adding a top level WordPress page and adding it to the menu on the object level.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class ObjectPage extends Page
{
    /**
     * Add the page to WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        add_object_page($this->title, $this->title, $this->capability, $this->getSlug(), array($this, 'display'), $this->menuIcon);
    }
}