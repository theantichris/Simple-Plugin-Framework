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
    /** @var string[]|bool $supports Registers support of certain features for a given post type. */
    private $supports = array('title', 'editor');

    /**
     * Sets up properties and ties the registerCustomPostType() method to the init WordPress action hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
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

        add_action('init', array($this, 'registerCustomPostType'));
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
     * @return CustomPostType
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
     * @return CustomPostType
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
     * @return CustomPostType
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
     * @return CustomPostType
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
     * @return CustomPostType
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
     * @param string[]|bool $supports Registers support of certain feature for a given post type.
     * @return CustomPostType
     */
    public function setSupports($supports)
    {
        if ($supports === true) {
            wp_die(__("The supports option must be an array or false", $this->textDomain));
        }

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
     * Calls the WordPress function register_post_type() if the post type does not already exist.
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerCustomPostType()
    {
        if (!post_type_exists($this->getSlug())) {
            $arguments = array(
                'labels'        => $this->labels,
                'public'        => $this->public,
                'menu-position' => $this->menuPosition,
                'menu-icon'     => $this->menuIcon,
                'capabilities'  => $this->capabilities,
                'supports'      => $this->supports,
            );

            register_post_type($this->getSlug(), $arguments);
        }
    }
}
