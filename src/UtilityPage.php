<?php

namespace theantichris\SPF;

/**
 * Class UtilityPage
 *
 * A class for adding a top level menu page at the 'utility' level.
 * This new menu will appear in the group including the default WordPress Appearance, Plugins, Users, Tools and Settings.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class UtilityPage extends Page
{
    /**
     * Calls the WordPress add_utility_page() function.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/add_utility_page
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        $name = $this->getName();

        add_utility_page($name, $name, $this->capability, $this->getSlug(), array($this, 'display'), $this->menuIcon);
    }
}