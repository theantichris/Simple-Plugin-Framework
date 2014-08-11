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
     * Base view helper to output various HTML input fields.
     * Gets called by public methods.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @param string $type The type of the input field.
     * @param mixed[] $attributes Data to pass add to the input as HTML attributes.
     * @return void
     */
    private static function ViewHelper($name, $slug, $type, $attributes = array())
    {
        $attributesString = '';

        foreach ($attributes as $key => $value) {
            $attributesString .= $key . '="' . $value . '" ';
        }

        $viewData = array(
            'name'       => $name,
            'slug'       => $slug,
            'type'       => $type,
            'attributes' => $attributesString,
        );

        View::render(__DIR__ . '/MetaBoxViews/Input.php', $viewData);
    }

    /**
     * View helper to output a checkbox field.
     *
     * @since 5.0.0
     *
     * TODO: Create its own view with hidden field.
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @param string $value The checkbox's value.
     * @return void
     */
    public static function CheckboxInput($name, $slug, $value)
    {
        self::ViewHelper($name, $slug, 'checkbox', array('value' => $value));
    }

    /**
     * View helper to output a color HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function ColorInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'color');
    }

    /**
     * View helper to output a date HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function DateInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'date');
    }

    /**
     * View helper to output a datetime HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function DateTimeInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'datetime');
    }

    /**
     * View helper to output a datetime-local HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function DateTimeLocalInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'datetime-local');
    }

    /**
     * View helper to output a email HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function EmailInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'email');
    }

    /**
     * View helper to output a month HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function MonthInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'month');
    }

    /**
     * View helper to output a number HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function NumberInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'number');
    }

    /**
     * View helper to output a password HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function PasswordInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'password');
    }

    // TODO: Radio buttons

    /**
     * View helper to output a range HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @param integer $min Minimum range.
     * @param integer $max Maximum range.
     * @return void
     */
    public static function RangeInput($name, $slug, $min, $max)
    {
        $attributes['min'] = $min;
        $attributes['max'] = $max;

        self::ViewHelper($name, $slug, 'range', $attributes);
    }

    /**
     * View helper to output a search HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function SearchInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'search');
    }

    // TODO: Select

    /**
     * View helper to output a telephone HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function TelInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'tel');
    }

    /**
     * View helper to output a textarea HTML field.
     *
     * @since 5.0.0
     *
     * TODO: Needs its own input.
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @param integer $rows Number of rows the textarea has.
     * @param integer $cols Number of cols the textarea has.
     * @return void
     */
    public static function Textarea($name, $slug, $rows, $cols)
    {
        $attributes['rows'] = $rows;
        $attributes['cols'] = $cols;

        self::ViewHelper($name, $slug, $attributes);
    }

    /**
     * View helper to output a text HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function TextInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'text');
    }

    /**
     * View helper to output a URL HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function UrlInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'url');
    }

    /**
     * View helper to output a week HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function WeekInput($name, $slug)
    {
        self::ViewHelper($name, $slug, 'week');
    }
}