<?php

namespace theantichris\WpPluginFramework;

/**
 * Class PageArg
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class PageArg
{
    /** @var  string */
    private $title;
    /** @var  View */
    private $view;
    /** @var  string */
    public $capability = 'manage_options';
    /** @var  string */
    public $menuIcon;
    /** @var  int */
    public $position;
    /** @var  string */
    public $parentSlug;
    /** @var  string */
    public $textDomain;

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
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getView()
    {
        return $this->view;
    }
}