<?php

namespace theantichris\WpPluginFramework;

/**
 * Class TaxonomyArg
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class TaxonomyArg
{
    /** @var string User readable name for the taxonomy. */
    private $name;
    /** @var string|string[] What post types the taxonomy will be registered to. */
    public $postTypes = 'post';
    /** @var array UI labels for the taxonomy. */
    private $labels;
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain;

    public function __construct($name, $textDomain = '')
    {
        $this->textDomain = $textDomain;

        if (empty($name)) {
            wp_die(__('You did not specify a name for your taxonomy.', $this->textDomain));
        } else {
            $this->name   = $name;
            $this->labels = $this->setLabels();
        }
    }

    /**
     * @since 1.2.0
     * @return string[]
     */
    private function setLabels()
    {
        /** @var string $singular Singular version of the taxonomy name. */
        $singular = Utilities::makeSingular($this->name);

        return array(
            'name'              => __($this->name, $this->textDomain),
            'singular_name'     => __($singular, $this->textDomain),
            'search_items'      => __('Search ' . $this->name, $this->textDomain),
            'all_items'         => __('All ' . $this->name, $this->textDomain),
            'parent_item'       => __('Parent ' . $singular, $this->textDomain),
            'parent_item_colon' => __('Parent ' . $singular . ':', $this->textDomain),
            'edit_item'         => __('Edit ' . $singular, $this->textDomain),
            'update_item'       => __('Update ' . $singular, $this->textDomain),
            'add_new_item'      => __('Add New ' . $singular, $this->textDomain),
            'new_item_name'     => __('New ' . $singular . ' Name', $this->textDomain),
            'menu_name'         => __($singular, $this->textDomain),
        );
    }

    /**
     * @since 1.2.0
     * @return string[]
     */
    public function getLabels()
    {
        return $this->labels;
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
} 