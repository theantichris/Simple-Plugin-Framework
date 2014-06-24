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
    /** @var  string */
    public $capability = 'manage_options';
    /** @var  string */
    public $menuIcon;
    /** @var  int */
    public $position;
    /** @var  string */
    public $parentSlug;
    /** @var string */
    protected $textDomain;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param string $title
     * @param View $view
     * @param string $textDomain
     */
    public function __construct($title, View $view, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($title)) {
            wp_die(__('You did not specify a title for your page.', $this->textDomain));
        } elseif (empty($view)) {
            wp_die(__('You did not specify a view for your page.', $this->textDomain));
        } else {
            $this->title                   = $title;
            $this->view                    = $view;
            $this->view->viewData['title'] = $this->title;
            $this->view->viewData['slug']  = sanitize_title($this->title);
        }

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
     * Displays the HTML output of the page.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function display()
    {
        if (!current_user_can($this->capability)) {
            wp_die(__('You do not have sufficient permissions to access this page.', $this->textDomain));
        }

        $this->view->render();
    }
}
