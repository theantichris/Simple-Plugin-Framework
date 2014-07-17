<?php

namespace theantichris\SPF;

/**
 * Class MenuPage
 *
 * A class for adding a top level menu page to the WordPress Dashboard. Extends Page.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class MenuPage extends Page
{
    /**
     * Calls the WordPress add_menu_page() function.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/add_menu_page
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        add_menu_page($this->getName(), $this->getName(), $this->capability, $this->getSlug(), array($this, 'display'), $this->menuIcon, $this->position);
    }
}