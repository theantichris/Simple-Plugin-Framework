<?php

namespace theantichris\spf;

/**
 * Class Page
 *
 * A base class for creating and managing WordPress Dashboard pages.
 *
 * @package theantichris\spf
 *
 * @since 0.1.0
 */
abstract class Page extends WordPressObject
{
    /** @var string The text to be displayed in the title tags of the page when the menu is selected. */
    protected $name;
    /** @var View The View object responsible for rendering the page. */
    protected $view;
    /** @var string The capability required for this menu to be displayed to the user. */
    protected $capability = Capability::manage_options;
    /** @var string The url to the icon to be used for this menu or the name of the icon from the iconfont. */
    protected $menuIcon;
    /** @var int The position in the menu order this menu should appear. */
    protected $position;

    /**
     * Sets properties and ties the addPage() method to the admin_menu hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
     *
     * @since 0.1.0
     *
     * @param string $name The text to be displayed in the title tags of the page when the menu is selected.
     * @param View $view The View object responsible for rendering the page.
     */
    public function __construct($name, View $view)
    {
        $this->name                   = $name;
        $this->view                   = $view;
        $this->view->viewData['name'] = $this->name;
        $this->view->viewData['slug'] = $this->getSlug();

        add_action('admin_menu', array($this, 'addPage'));
    }

    /**
     * Checks if the given capability is a valid WordPress capability and if it is assigns it to $capability.
     *
     * @since 3.0.0
     *
     * @param string $capability The capability required for this menu to be displayed to the user.
     * @return Page
     */
    public function setCapability($capability)
    {
        if (Capability::isValid($capability)) {
            $this->capability = $capability;
        } else {
            wp_die(__("{$capability} is not a valid WordPress capability.", parent::$textDomain));
        }

        return $this;
    }

    /**
     * Sets the page's menu icon to a URL or Dashicon.
     * @link http://melchoyce.github.io/dashicons/
     *
     * @since 3.0.0
     *
     * @param string $icon The url to the icon to be used for this menu or the name of the icon from the iconfont.
     * @return Page
     */
    public function setMenuIcon($icon)
    {
        $this->menuIcon = $icon;

        return $this;
    }

    /**
     * Sets $position.
     *
     * @since 3.0.0
     *
     * @param int|string $position The position in the menu order this menu should appear.
     * @return Page
     */
    public function setPosition($position)
    {
        $this->position = intval($position);

        return $this;
    }

    /**
     * Adds the page to WordPress. Overridden in the child class to use the specific WordPress function for that type.
     * Should not be called directly. It is only public so WordPress can call it.
     *
     * @since 0.1.1
     *
     * @return void
     */
    abstract public function addPage();

    /**
     * Displays the HTML output of the page if the user has the correct capability.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/current_user_can
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function display()
    {
        if (!current_user_can($this->capability)) {
            wp_die(__('You do not have sufficient permissions to access this page.', parent::$textDomain));
        }

        $this->view->render();
    }
}
