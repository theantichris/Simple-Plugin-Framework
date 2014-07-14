<?php

namespace theantichris\SPF;

/**
 * Class PostType
 *
 * A class for creating and managing post types in WordPress.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class PostType extends WordPressObject
{
    /** @var string General name for the post type, must be plural. */
    protected $name;
    /** @var string[] An array of labels for this post type. */
    private $labels;
    /** @var string A short descriptive summary of what the post type is. */
    private $description;
    /** @var bool Whether a post type is intended to be used publicly either via the admin interface or by front-end users. */
    private $public = true;
    /** @var int The position in the menu order the post type should appear. */
    private $menuPosition;
    /** @var  string The url to the icon to be used for this menu or the name of the icon from the iconfont */
    private $menuIcon;
    /** @var string[] Capabilities to set for the post type. */
    private $capabilities = array(
        'edit_post'          => Capability::edit_posts,
        'read_post'          => Capability::read_posts,
        'delete_post'        => Capability::delete_posts,
        'edit_posts'         => Capability::edit_posts,
        'edit_others_posts'  => Capability::edit_others_posts,
        'publish_posts'      => Capability::publish_posts,
        'read_private_posts' => Capability::read_private_posts,
    );
    /** @var string[]|bool $supports Registers support of certain features for a given post type. */
    private $supports = array('title', 'editor');

    /**
     * Sets up properties and ties the registerPostType() method to the init WordPress action hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     *
     * @since 0.1.0
     *
     * @param string $name General name for the post type, must be plural.
     */
    function __construct($name)
    {
        $this->name   = $name;
        $this->labels = $this->setLabels();

        add_action('init', array($this, 'registerPostType'));
    }

    /**
     * Sets up the labels for the post type..
     *
     * @since 3.0.0
     *
     * @return string[]
     */
    private function setLabels()
    {
        /** @var string $singular Singular version of $name. */
        $singular = $this->makeSingular($this->name);

        /** @var string[] $labels */
        $labels = array(
            'name'               => __($this->name, parent::$textDomain),
            'singular_name'      => __($singular, parent::$textDomain),
            'add_new'            => __('Add New', parent::$textDomain),
            'add_new_item'       => __('Add New ' . $singular, parent::$textDomain),
            'edit_item'          => __('Edit ' . $singular, parent::$textDomain),
            'new_item'           => __('New ' . $singular, parent::$textDomain),
            'all_items'          => __('All ' . $this->name, parent::$textDomain),
            'view_item'          => __('View ' . $singular, parent::$textDomain),
            'search_items'       => __('Search ' . $this->name, parent::$textDomain),
            'not_found'          => __('No ' . strtolower($this->name) . ' found.', parent::$textDomain),
            'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.', parent::$textDomain),
            'parent_item_colon'  => '',
            'menu_name'          => __($this->name, parent::$textDomain)
        );

        return $labels;
    }

    /**
     * Sets the $description property.
     *
     * @since 3.0.0
     *
     * @param string $description A short descriptive summary of what the post type is.
     * @return PostType
     */
    public function setDescription($description)
    {
        $this->description = __($description, parent::$textDomain);

        return $this;
    }

    /**
     * Sets the $public property.
     *
     * @since 3.0.0
     *
     * @param bool $public Whether a post type is intended to be used publicly either via the admin interface or by front-end users.
     * @return PostType
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Set's $menuPosition.
     *
     * @since 3.0.0
     *
     * @param int|string $position The position in the menu order the post type should appear.
     * @return PostType
     */
    public function setMenuPosition($position)
    {
        $this->menuPosition = intval($position);

        return $this;
    }

    /**
     * Sets $menuIcon.
     * @link http://melchoyce.github.io/dashicons/
     *
     * @since 3.0.0
     *
     * @param string $icon The url to the icon to be used for this menu or the name of the icon from the iconfont.
     * @return PostType
     */
    public function setMenuIcon($icon)
    {
        $this->menuIcon = $icon;

        return $this;
    }

    /**
     * Sets $capabilities if all capabilities are valid.
     *
     * @since 3.0.0
     *
     * @param string[] $capabilities An array of the capabilities for this post type.
     * @return PostType
     */
    public function setCapabilities($capabilities)
    {
        foreach ($capabilities as $capability) {
            if (!Capability::isValid($capability)) {
                wp_die(__("{$capability} is not a valid WordPress capability."), parent::$textDomain);
            }
        }

        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Sets $supports.
     *
     * @since 3.0.0
     *
     * @param string[]|bool $supports Registers support of certain feature for a given post type.
     * @return PostType
     */
    public function setSupports($supports)
    {
        if ($supports === true) {
            wp_die(__("The supports option must be an array or false", parent::$textDomain));
        }

        $this->supports = $supports;

        return $this;
    }

    /**
     * Calls the WordPress function register_post_type() if the post type does not already exist.
     * This function should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerPostType()
    {
        if (!post_type_exists($this->getSlug())) {
            $arguments = array(
                'labels'        => $this->labels,
                'description'   => $this->description,
                'public'        => $this->public,
                'menu_position' => $this->menuPosition,
                'menu_icon'     => $this->menuIcon,
                'capabilities'  => $this->capabilities,
                'supports'      => $this->supports,
            );

            register_post_type($this->getSlug(), $arguments);
        }
    }
}
