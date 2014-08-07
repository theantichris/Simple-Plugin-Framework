<?php

namespace theantichris\SPF;

/**
 * Class Taxonomy
 *
 * A class for creating and managing WordPress taxonomies.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class Taxonomy extends WordPressObject
{
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
     * @param string $slug Unique identifier for the object in the WordPress database.
     * @param string|string[] $postTypes Slug of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered.
     */
    public function __construct($name, $slug, $postTypes = 'post')
    {
        $this->name      = $name;
        $this->slug      = $slug;
        $this->postTypes = $postTypes;
        $this->labels    = $this->setLabels();

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
        $singular = Helper::makeSingular($this->name);

        $textDomain = parent::$textDomain;

        return array(
            'name'              => __($this->name, $textDomain),
            'singular_name'     => __($singular, $textDomain),
            'search_items'      => __('Search ' . $this->name, $textDomain),
            'all_items'         => __('All ' . $this->name, $textDomain),
            'parent_item'       => __('Parent ' . $singular, $textDomain),
            'parent_item_colon' => __('Parent ' . $singular . ':', $textDomain),
            'edit_item'         => __('Edit ' . $singular, $textDomain),
            'update_item'       => __('Update ' . $singular, $textDomain),
            'add_new_item'      => __('Add New ' . $singular, $textDomain),
            'new_item_name'     => __('New ' . $singular . ' Name', $textDomain),
            'menu_name'         => __($singular, $textDomain),
        );
    }

    /**
     * Registers the taxonomy with WordPress if it has not already been registered. Called during the init action hook.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerCustomTaxonomy()
    {
        $slug = $this->getSlug();

        if (!taxonomy_exists($slug)) {
            /** @var string[] $arguments */
            $arguments = array(
                'labels' => $this->labels,
            );

            register_taxonomy($slug, $this->postTypes, $arguments);
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
        $terms = $this->terms;

        if (is_array($terms)) {
            if (!array_key_exists($term, $terms)) {
                $terms[$term] = $description;
            }
        } else {
            $terms[$term] = $description;
        }

        add_action('init', array($this, 'insertTerms'));

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
        /** @var string $description */
        foreach ($this->terms as $term => $description) {
            if (!term_exists($term['name'])) {
                wp_insert_term(__($term, parent::$textDomain), $this->getSlug(), array('description' => $description));
            }
        }
    }
} 
