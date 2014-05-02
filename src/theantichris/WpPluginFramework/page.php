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
    protected $pageTitle;
    /** @var string Unique ID for the page. */
    protected $pageSlug;
    /** @var string The capability required for the menu item to be displayed to the user. */
    protected $capability = 'manage_options';
    /** @var string|null The URL to the icon to be used for the menu item. */
    protected $menuIcon = null;
    /** @var integer|null The position in the menu this page should appear. */
    protected $position = null;
    /** @var string The full path to the view file that will display the content. */
    protected $viewPath;
    /** @var array Any variables that the templates need access to in an associative array. */
    protected $viewData = array();
    /** @var string The WordPress slug for the parent page. */
    protected $parentSlug;
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param string $pageTitle User readable title for the page and menu item.
     * @param string $viewPath Path to the view file the page will use to display content.
     * @param string $capability The capability required for the menu item to be displayed to the user.
     * @param string|null $menuIcon The URL to the icon to be used for the menu item.
     * @param string|null $position The position in the menu this page should appear.
     * @param array $viewData Any variables that the templates need access to in an associative array.
     * @param array|null $parentSlug The WordPress slug for the parent page.
     * @param string $textDomain Text domain for the plugin.
     * @return Page
     */
    public function __construct($pageTitle, $viewPath, $capability = null, $menuIcon = null, $position = null,  $viewData = array(), $parentSlug = null, $textDomain = '')
    {
        $this->pageTitle = $pageTitle;
        $this->pageSlug = sanitize_title($pageTitle);

        $this->viewPath = $viewPath;

        if (!empty($capability)) {
            $this->capability = $capability;
        }

        if (!empty($menuIcon)) {
            $this->menuIcon = $menuIcon;
        }

        if (!empty($position)) {
            $this->position = $position;
        }

        if (!empty($viewData)) {
            $this->viewData = $viewData;
        }

        $this->viewData['title'] = $this->pageTitle;
        $this->viewData['slug'] = $this->pageSlug;

        $this->parentSlug = $parentSlug;

        $this->textDomain = $textDomain;

        add_action('admin_menu', array($this, 'addPage'));
    }

    /**
     * Returns the $pageSlug property.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getPageSlug()
    {
        return $this->pageSlug;
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
        remove_menu_page($this->pageSlug);
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

        echo View::render($this->viewPath, $this->viewData);
    }
}