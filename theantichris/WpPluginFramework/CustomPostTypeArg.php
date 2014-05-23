<?php

namespace theantichris\WpPluginFramework;


/**
 * Class CustomPostTypeArg
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class CustomPostTypeArg
{
    /** @var string User-readable plural name of the post type. */
    private $name;
    /** @var bool If the post type is publicly accessible by admin and front-end. */
    public $public = false;
    /** @var string[] An array of labels for the post type. */
    public $labels;
    /** @var string URL to the post type's menu icon. */
    public $menuIcon;
    /** @var string[] The post type's capabilities. */
    public $capabilities = array(
        'edit_post'          => 'edit_post',
        'read_post'          => 'read_post',
        'delete_post'        => 'delete_post',
        'edit_posts'         => 'edit_posts',
        'edit_others_posts'  => 'edit_others_post',
        'publish_posts'      => 'publish_posts',
        'read_private_posts' => 'read_private_posts'
    );
    /** @var string[] What WordPress features the post type supports. */
    public $supports = array('title', 'editor');
    /** @var string The text domain for translation. */
    public $textDomain;

    /**
     * @since 1.2.0
     * @param string $name
     */
    public function __construct($name)
    {
        if (empty($name)) {
            wp_die('You did not specify a name for your post type.');
        } else {
            $this->name = $name;
        }
    }

    /**
     * @since 1.2.0
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}