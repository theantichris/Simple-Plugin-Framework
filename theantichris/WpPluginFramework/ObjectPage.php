<?php

namespace theantichris\WpPluginFramework;

/**
 * Class ObjectPage
 *
 * A class for adding a top level menu page at the 'object' level.
 * This new menu will appear in the group including the default WordPress Posts, Media, Links, Pages and Comments.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class ObjectPage extends Page
{
    /**
     * Calls the WordPress add_object_page() function.
     * @link http://codex.wordpress.org/Function_Reference/add_object_page
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