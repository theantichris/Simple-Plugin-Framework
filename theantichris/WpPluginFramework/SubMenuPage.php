<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SubMenuPage
 *
 * A class for adding a sub menu page from the WordPress Dashboard. Extends Page.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class SubMenuPage extends Page
{
    /**
     * Calls the WordPress add_submenu_page() function.
     * @link http://codex.wordpress.org/Function_Reference/add_submenu_page
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        add_submenu_page($this->parentSlug, $this->title, $this->title, $this->capability, $this->getSlug(), array($this, 'display'));
    }

    /**
     * Validates and sets the page's parent slug.
     *
     * @since 3.0.0
     *
     * @param string $slug The slug name for the parent menu (or the file name of a standard WordPress admin page). Use NULL if you want to create a page that doesn't appear in any menu.
     * @return SubMenuPage
     */
    public function setParentSlug($slug)
    {
        if (empty($slug)) {
            wp_die(__("The parent menu for the {$this->title} page cannot be blank.", $this->textDomain));
        } else {
            $this->parentSlug = $slug;
        }

        return $this;
    }
}