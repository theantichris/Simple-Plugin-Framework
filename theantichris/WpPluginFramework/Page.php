<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Page
 *
 * A base class for creating and managing WordPress Dashboard pages.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
abstract class Page
{
    /** @var string User readable title for the page and menu item. */
    protected $title;
    /** @var  View */
    protected $view;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param PageArg $pageArg
     */
    public function __construct(PageArg $pageArg)
    {
        $this->title = $pageArg->getTitle();
        $this->view = $pageArg->getView();

        add_action('admin_menu', array($this, 'addPage'));
    }

    /**
     * Returns the $slug property.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getSlug()
    {
        return sanitize_title($this->title);
    }

    /**
     * Adds the page to WordPress.
     *
     * @since 0.1.1
     *
     * @return void
     */
    abstract public function addPage();

    /**
     * Removes a page from WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function removePage()
    {
        remove_menu_page($this->slug);
    }

    /**
     * Displays the HTML output of the page.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function displayPage()
    {
        if (!current_user_can($this->capability)) {
            wp_die(__('You do not have sufficient permissions to access this page.', $this->textDomain));
        }

        $view = new View($this->viewPath, $this->viewData);

        echo $view->render();
    }
}
