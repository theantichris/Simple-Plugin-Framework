<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Taxonomy
 *
 * A class for creating and managing WordPress taxonomies.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class Taxonomy
{
    /** @var string The name of the taxonomy. Must be plural. */
    private $name;
    /** @var string Text domain used for translation. */
    private $textDomain;
    /** @var string|string[] Slug of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered. */
    private $postTypes;
    /** @var array An array of labels for this taxonomy. */
    private $labels;
    /** @var string[] An associative array of terms registered to the taxonomy. The term name is the key and the value is the description. */
    private $terms;

    /**
     * Sets properties and ties the registerCustomTaxonomy() method to the init action hook.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     *
     * @since 0.1.0
     *
     * @param string $name The name of the taxonomy. Must be plural.
     * @param string|string[] $postTypes Slug of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered.
     * @param string $textDomain Text domain used for translation.
     */
    public function __construct($name, $postTypes = 'post', $textDomain = '')
    {
        $this->name       = $name;
        $this->textDomain = $textDomain;
        $this->postTypes  = $postTypes;
        $this->labels     = $this->setLabels();

        add_action('init', array($this, 'registerCustomTaxonomy'));
    }

    /**
     * Sets up the label array based on $name.
     *
     * @since 2.0.0
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
     * Returns the taxonomies slug by sanitizing the name.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getSlug()
    {
        return sanitize_title($this->name);
    }

    /**
     * Registers the taxonomy with WordPress if it has not already been registered. Called during the init action hook.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerCustomTaxonomy()
    {
        if (!taxonomy_exists($this->getSlug())) {
            /** @var string[] $arguments */
            $arguments = array(
                'labels' => $this->labels,
            );

            register_taxonomy($this->getSlug(), $this->postTypes, $arguments);
        }
    }

    /**
     * Adds a term to the $terms property. Registers the insertTerms() method to the init action hook
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     *
     * @since 0.1.0
     *
     * @param string $term The term to add to the taxonomy.
     * @param string $description The term's description.
     * @return Taxonomy
     */
    public function addTerm($term, $description = '')
    {
        if (is_array($this->terms)) {
            if (!array_key_exists($term, $this->terms)) {
                $this->terms[$term] = $description;
                add_action('init', array($this, 'insertTerms'));
            }
        } else {
            $this->terms[$term] = $description;
        }

        return $this;
    }

    /**
     * Calls the WordPress function wp_insert_term for each term in the $terms array. Tied to the init hook.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/wp_insert_term
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function insertTerms()
    {
        /** @var string $term */
        foreach ($this->terms as $term => $description) {
            if (!term_exists($term['name'])) {
                wp_insert_term(__($term, $this->textDomain), $this->getSlug(), array('description' => $description));
            }
        }
    }
} 
