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
    private $labels;
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
    private $textDomain;

    /**
     * @since 1.2.0
     *
     * @param string $name
     * @param string $textDomain
     */
    public function __construct($name, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($name)) {
            wp_die(__('You did not specify a name for your post type.', $this->textDomain));
        } else {
            $this->name   = $name;
            $this->labels = $this->setLabels();
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

    /**
     * @since 1.2.0
     * @return string
     */
    public function getSlug()
    {
        return sanitize_title($this->name);
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

    /**
     * @since 1.2.0
     * @return \string[]
     */
    public function getLabels()
    {
        return $this->labels;
    }
}