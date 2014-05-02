<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Menu_Page
 *
 * A class for adding a top level menu page to the WordPress Dashboard. Extends Page.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class MenuPage extends Page
{
    /**
     * Adds the page to WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        add_menu_page(
            $this->pageTitle,
            $this->pageTitle,
            $this->capability,
            $this->pageSlug,
            array($this, 'displayPage'),
            $this->menuIcon,
            $this->position
        );
    }
}