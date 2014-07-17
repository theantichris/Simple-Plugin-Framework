<?php

namespace theantichris\SPF;

/**
 * Class MetaBox
 * @package theantichris\SPF
 * @since 3.0.0
 */
class MetaBox extends WordPressObject
{
    /** @var string Title of the edit screen section, visible to user. */
    protected $name;
    /** @var View The View object responsible for printing out the HTML for the edit screen section. */
    private $view;
    /** @var string[] The type of Write screen on which to show the edit screen section. */
    private $postTypes = array();
    /** @var string The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). */
    private $context = 'advanced';
    /** @var string The priority within the context where the boxes should show ('high', 'core', 'default' or 'low'). */
    private $priority = 'default';
    /** @var mixed[]|null Arguments to pass into your callback function. The callback will receive the $post object and whatever parameters are passed through this variable. */
    private $args = null;

    /**
     * Sets properties and ties the addMetaBox method to the add_meta_boxes hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
     *
     * @since 3.0.0
     *
     * @param string $name Title of the edit screen section, visible to user.
     * @param View $view The View object responsible for printing out the HTML for the edit screen section.
     * @param string|string[] $postTypes The type of Write screen on which to show the edit screen section.
     */
    function __construct($name, $view, $postTypes)
    {
        $this->name                   = $name;
        $this->view                   = $view;
        $this->view->viewData['name'] = $this->name;
        $this->view->viewData['slug'] = $this->getSlug();

        if (is_array($postTypes)) {
            $this->postTypes = $postTypes;
        } else {
            $this->postTypes[] = $postTypes;
        }


        add_action('add_meta_boxes', array($this, 'addMetaBox'));
    }

    /**
     * @since 3.0.0
     *
     * @param string $context
     * @return MetaBox
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @since 3.0.0
     *
     * @param string $priority
     * @return MetaBox
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @since 3.0.0
     *
     * @param \mixed[] $args
     * @return MetaBox
     */
    public function setArgs($args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Calls the WordPress function add_meta_box().
     * Do not call directly, it is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addMetaBox()
    {
        /** @var string $postType */
        foreach ($this->postTypes as $postType) {
            add_meta_box($this->getSlug(), __($this->name, self::$textDomain), array($this->view, 'render'), $postType, $this->context, $this->priority, $this->args);
        }
    }
}