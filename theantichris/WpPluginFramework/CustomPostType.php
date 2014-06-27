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
    /** @var bool Whether a post type is intended to be used publicly either via the admin interface or by front-end users. */
    private $public = true;
    /** @var string */
    private $textDomain;

    /** @var  string URL to the plugin icon file. */
    private $menuIcon;
    /** @var string[] Capabilities to set for the post type. */
    private $capabilities;
    /** @var string[] $supports What features the post type supports. */
    private $supports;
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
        $this->textDomain = $textDomain;

        if (empty($name)) {
            wp_die(__('You did not specify a name for your custom post type.', $this->textDomain));
        } else {
            $this->name = $name;
            $this->labels = $this->setLabels();
        }

//        $this->menuIcon     = $customPostTypeArgs->menuIcon;
//        $this->capabilities = $customPostTypeArgs->capabilities;
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
     * Checks if $public is a bool and if so sets the property.
     *
     * @since 3.0.0
     *
     * @param bool $public Whether a post type is intended to be used publicly either via the admin interface or by front-end users.
     * @return $this
     */
    public function setPublic($public)
    {
        if (is_bool($public)) {
            $this->public = $public;
        } else {
            wp_die(__("The public option for the {$this->name} post type must be a boolean.", $this->textDomain));
        }

        return $this;
    }

    /**
     * @since 3.0.0
     *
     * @return string
     * @return void
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
