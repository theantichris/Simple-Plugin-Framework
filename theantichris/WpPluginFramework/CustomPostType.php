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
    private $name;
    /** @var  string WordPress slug for the post type. */
    private $slug;
    /** @var bool If the post type is publicly accessible by admin and front-end. */
    public $public = false;
    /** @var  mixed[] Arguments for the register_post_type() function. */
    private $arguments = array();
    /** @var string[] Labels for the post type. */
    private $labels = array();
    /** @var  string URL to the plugin icon file. */
    private $menuIcon;
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain = '';

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

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param CustomPostTypeArg $args Object containing arguments for creating a custom post type.
     */
    function __construct(CustomPostTypeArg $args)
    {
        foreach ($args as $key => $value) {
            if (!empty($value)) {
                $this->{$key} = $value;
            }
        }

        $this->slug = sanitize_title($args->name);

        if (empty($this->labels)) {
            $this->labels = $this->setLabels();
        }

        $this->arguments = $this->setArguments();

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
        if (!post_type_exists($this->slug)) {
            register_post_type($this->slug, $this->arguments);
        }
    }

    /**
     * Returns $slug.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getPostSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the $arguments properties.
     *
     * @since 1.2.0
     *
     * @return mixed[]
     */
    private function setArguments()
    {
        $arguments = array(
            'labels'       => $this->labels,
            'public'       => $this->public,
            'menuIcon'     => $this->menuIcon,
            'capabilities' => $this->capabilities,
            'supports'     => $this->supports
        );

        return $arguments;
    }

    /**
     * Sets the $labels property.
     *
     * @since 1.2.0
     *
     * @return string[]
     */
    private function setLabels()
    {
        /** @var string $singular Singular version of $name. */
        $singular = Utilities::makeSingular($this->name);

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
}
