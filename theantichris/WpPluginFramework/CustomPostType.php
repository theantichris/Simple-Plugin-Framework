<?php

namespace theantichris\WpPluginFramework;

/**
 * Class CustomPostType
 *
 * A class for creating and managing a custom post type in WordPress.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class CustomPostType
{
    /** @var  string General name for the post type, must be plural. */
    private $name;
    /** @var string[] An array of labels for this post type. */
    private $labels;
    /** @var string A short descriptive summary of what the post type is. */
    private $description;
    /** @var bool Whether a post type is intended to be used publicly either via the admin interface or by front-end users. */
    private $public = true;
    /** @var string */
    private $textDomain;
    /** @var int The position in the menu order the post type should appear. */
    private $menuPosition;
    /** @var  string The url to the icon to be used for this menu or the name of the icon from the iconfont */
    private $menuIcon;
    /** @var string[] Capabilities to set for the post type. */
    private $capabilities = array(
        'edit_posts'         => Capability::edit_posts,
        'edit_others_posts'  => Capability::edit_others_posts,
        'publish_posts'      => Capability::publish_posts,
        'read_private_posts' => Capability::read_private_posts,
    );
    /** @var string[] $supports Registers support of certain features for a given post type. */
    private $supports = array('title', 'editor');
    /** @var  mixed[] Arguments for the register_post_type() function. */
    private $arguments;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param string $name General name for the post type, must be plural.
     * @param string $textDomain
     */
    function __construct($name, $textDomain = '')
    {
        $this->name       = $name;
        $this->textDomain = $textDomain;
        $this->labels     = $this->setLabels();

//        $this->supports     = $customPostTypeArgs->supports;
//
//        $this->arguments = $this->setArguments();
//
//        add_action('init', array($this, 'registerCustomPostType'));
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
        $singular = Utilities::makeSingular($this->name);

        /** @var string[] $labels */
        $labels = array(
            'name'               => __($this->name, $this->textDomain),
            'singular_name'      => __($singular, $this->textDomain),
            'add_new'            => __('Add New', $this->textDomain),
            'add_new_item'       => __('Add New ' . $singular, $this->textDomain),
            'edit_item'          => __('Edit ' . $singular, $this->textDomain),
            'new_item'           => __('New ' . $singular, $this->textDomain),
            'all_items'          => __('All ' . $this->name, $this->textDomain),
            'view_item'          => __('View ' . $singular, $this->textDomain),
            'search_items'       => __('Search ' . $this->name, $this->textDomain),
            'not_found'          => __('No ' . strtolower($this->name) . ' found.', $this->textDomain),
            'not_found_in_trash' => __(
                'No ' . strtolower($this->name) . ' found in Trash.',
                $this->textDomain
            ),
            'parent_item_colon'  => '',
            'menu_name'          => __($this->name, $this->textDomain)
        );

        return $labels;
    }

    /**
     * Sets the $description property.
     *
     * @since 3.0.0
     *
     * @param string $description A short descriptive summary of what the post type is.
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets the $public property.
     *
     * @since 3.0.0
     *
     * @param bool $public Whether a post type is intended to be used publicly either via the admin interface or by front-end users.
     * @return $this
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
     * @return $this
     */
    public function setMenuPosition($position)
    {
        $this->menuPosition = intval($position);

        return $this;
    }

    /**
     * Sets $menuIcon.
     *
     * @since 3.0.0
     *
     * @param string $icon The url to the icon to be used for this menu or the name of the icon from the iconfont.
     * @return $this
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
     * @return $this
     */
    public function setCapabilities($capabilities)
    {
        foreach ($capabilities as $capability) {
            if (!Capability::isValid($capability)) {
                wp_die(__("{$capability} is not a valid WordPress capability."), $this->textDomain);
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
     * @param string[] $supports Registers support of certain feature for a given post type.
     * @return $this
     */
    public function setSupports($supports)
    {
        $this->supports = $supports;

        return $this;
    }

    /**
     * @since 3.0.0
     *
     * @return string
     */
    public function getSlug()
    {
        return sanitize_title($this->name);
    }

    /**
     * Sets the $arguments properties.
     *
     * @since 2.0.0
     *
     * @return mixed[]
     */
    private function setArguments()
    {
        return array(
            'labels'       => $this->labels,
            'public'       => $this->public,
            'menuIcon'     => $this->menuIcon,
            'capabilities' => $this->capabilities,
            'supports'     => $this->supports,
        );
    }

    /**
     * Registers the custom post type with WordPress if it does not already exists.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerCustomPostType()
    {
        if (!post_type_exists($this->getSlug())) {
            register_post_type($this->getSlug(), $this->arguments);
        }
    }
}
