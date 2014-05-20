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
    /** @var  string User readable name for the post type. Must be plural. */
    private $postTypeName;
    /** @var  string WordPress slug for the post type. */
    private $postTypeSlug;
    /** @var  array Arguments for the register_post_type() function. */
    private $postTypeArgs = array();
    /** @var array Labels for the post type. */
    private $postTypeLabels = array();
    /** @var  string URL to the plugin icon file. */
    private $menuIcon;
    /** @var string[] Capabilities to set for the post type. */
    private $capabilities = array(
        'edit_post'          => 'edit_post',
        'read_post'          => 'read_post',
        'delete_post'        => 'delete_post',
        'edit_posts'         => 'edit_posts',
        'edit_others_posts'  => 'edit_others_post',
        'publish_posts'      => 'publish_posts',
        'read_private_posts' => 'read_private_posts'
    );
    /** @var string[] $supports What features the post type supports. */
    private $supports = array('title', 'editor');
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param \stdClass $args Object containing arguments for creating a custom post type.
     */
    function __construct($args)
    {
        $this->postTypeName = $args->postTypeName;
        $this->postTypeSlug = sanitize_title($args->postTypeName);

        if (!empty($args->capabilities)) {
            $this->capabilities = $args->capabilities;
        }

        if (!empty($args->supports)) {
            $this->supports = $args->supports;
        }

        $this->menuIcon = $args->menuIcon;

        $this->textDomain = $args->textDomain;

        /** @var string $singular Singular version of $postTypeName. */
        $singular = Utilities::makeSingular($this->postTypeName);

        $this->postTypeLabels = array(
            'name'               => __($this->postTypeName, $this->textDomain),
            'singular_name'      => __($singular, $this->textDomain),
            'add_new'            => __('Add New', $this->textDomain),
            'add_new_item'       => __('Add New ' . $singular, $this->textDomain),
            'edit_item'          => __('Edit ' . $singular, $this->textDomain),
            'new_item'           => __('New ' . $singular, $this->textDomain),
            'all_items'          => __('All ' . $this->postTypeName, $this->textDomain),
            'view_item'          => __('View ' . $singular, $this->textDomain),
            'search_items'       => __('Search ' . $this->postTypeName, $this->textDomain),
            'not_found'          => __('No ' . strtolower($this->postTypeName) . ' found.', $this->textDomain),
            'not_found_in_trash' => __(
                'No ' . strtolower($this->postTypeName) . ' found in Trash.',
                $this->textDomain
            ),
            'parent_item_colon'  => '',
            'menu_name'          => __($this->postTypeName, $this->textDomain)
        );

        $this->postTypeArgs = array(
            'labels'       => $this->postTypeLabels,
            'public'       => true,
            'menuIcon'     => $this->menuIcon,
            'capabilities' => $this->capabilities,
            'supports'     => $this->supports
        );

        add_action('init', array($this, 'register_custom_post_type'));
    }

    /**
     * Registers the custom post type with WordPress if it does not already exists.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function register_custom_post_type()
    {
        if (!post_type_exists($this->postTypeSlug)) {
            register_post_type($this->postTypeSlug, $this->postTypeArgs);
        }
    }

    /**
     * Returns $postTypeSlug.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getPostSlug()
    {
        return $this->postTypeSlug;
    }
}
