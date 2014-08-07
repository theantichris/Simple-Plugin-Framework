<?php

namespace theantichris\SPF;

/**
 * Class MetaBox
 * @package theantichris\SPF
 * @since 3.0.0
 */
class MetaBox extends WordPressObject
{
    /** @var string[] The type of Write screen on which to show the edit screen section. */
    private $postTypes = array();
    /** @var string The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). */
    private $context = 'advanced';
    /** @var string The priority within the context where the boxes should show ('high', 'core', 'default' or 'low'). */
    private $priority = 'default';

    /**
     * Sets properties, ties the addMetaBox method to the add_meta_boxes hook, and ties the saveMetaBox method to the save_post hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/save_post
     *
     * @since 3.0.0
     *
     * @param string $name Title of the edit screen section, visible to user.
     * @param string|string[] $postTypes The type of Write screen on which to show the edit screen section.
     * @param string $viewFile The View object responsible for printing out the HTML for the edit screen section.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    function __construct($name, $postTypes, $viewFile, $viewData = array())
    {
        $this->name             = $name;
        $this->viewFile         = $viewFile;
        $this->viewData         = $viewData;
        $this->viewData['name'] = $this->getName();

        if (is_array($postTypes)) {
            $this->postTypes = $postTypes;
        } else {
            $this->postTypes[] = $postTypes;
        }

        add_action('add_meta_boxes', array($this, 'addMetaBox'));
        add_action('save_post', array($this, 'saveMetaBox'));
    }

    /**
     * Sets the WordPress context of the meta box.
     *
     * @since 3.0.0
     *
     * @param string $context The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
     * @return MetaBox
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Sets the WordPress priority of the meta box.
     *
     * @since 3.0.0
     *
     * @param string $priority The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
     * @return MetaBox
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

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
            add_meta_box($this->getSlug(), $this->getName(), array($this, 'displayMetaBox'), $postType, $this->context, $this->priority);
        }
    }

    /**
     * Method that saves the meta box when the post is updated.
     * Do not call directly, it is only public so WordPress can call it.
     *
     * @since 3.0.0
     *
     * @param int $postId ID of the current WordPress post.
     * @return void
     */
    public function saveMetaBox($postId)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $postId)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $postId)) {
                return;
            }
        }

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'spf-meta-') !== false) {
                $key = str_replace('spf-meta-', '', $key);
                update_post_meta($postId, $key, sanitize_text_field($value));
            }
        }
    }

    /**
     * Special display callback for the object that takes a WordPress post object as a parameter.
     * Do not call directly, it is only public so WordPress can call it.
     *
     * @since 3.0.0
     *
     * @param \WP_Post $post The current WordPress post object.
     * @return void
     */
    public function displayMetaBox($post)
    {
        $this->viewData['post'] = $post;
        View::render($this->viewFile, $this->viewData);
    }

    /**
     * Outputs a text HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function TextInput($name, $slug)
    {
        $viewData = array(
            'name' => $name,
            'slug' => $slug,
        );

        View::render(__DIR__ . '/MetaBoxInputs/TextInput.php', $viewData);
    }
}