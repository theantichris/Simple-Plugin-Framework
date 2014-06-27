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
    /** @var bool If the post type is publicly accessible by admin and front-end. */
    public $public;
    /** @var string[] Labels for the post type. */
    private $labels;
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
     * @param string $name
     * @param string $textDomain
     */
    function __construct($name, $textDomain = '')
    {
        $this->name = $name;

        $this->public       = $customPostTypeArgs->public;
        $this->labels       = $customPostTypeArgs->getLabels();
        $this->menuIcon     = $customPostTypeArgs->menuIcon;
        $this->capabilities = $customPostTypeArgs->capabilities;
        $this->supports     = $customPostTypeArgs->supports;

        $this->arguments = $this->setArguments();

        add_action('init', array($this, 'registerCustomPostType'));
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
