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
    /** @var string User readable name for the taxonomy. */
    private $name;
    /** @var string */
    private $textDomain;
    /** @var array|string What post types the taxonomy will be registered to. */
    private $postTypes;
    /** @var array UI labels for the taxonomy. */
    private $labels;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param string $name
     * @param string $textDomain
     */
    public function __construct($name, $textDomain = '')
    {
        $this->name       = $name;
        $this->textDomain = $textDomain;
        $this->labels     = $this->setLabels();

        $this->postTypes = $taxonomyArg->postTypes;

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
     * Registers the taxonomy with WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerCustomTaxonomy()
    {
        if (!taxonomy_exists($this->slug)) {
            /** @var string[] $arguments */
            $arguments = array(
                'labels' => $this->labels,
            );

            register_taxonomy($this->slug, $this->postTypes, $arguments);
        }
    }

    /**
     * Validates a term or list of terms to add to the taxonomy then calls insertTerm() to add it to the database.
     *
     * @since 0.1.0
     *
     * @param string|array $terms Terms to add to the taxonomy.
     * @param string $textDomain
     * @return void
     */
    public function addTerms($terms, $textDomain = '')
    {
        if (is_array($terms)) {
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if ('' != trim($term)) {
                        $this->insertTerm(trim($term), $textDomain);
                    }
                }
            }
        } else {
            if ('' != trim($terms)) {
                $this->insertTerm(trim($terms), $textDomain);
            }
        }
    }

    /**
     * Adds a term to the WordPress database after being validated by addTerms().
     *
     * @since 0.1.0
     *
     * @param string $term Validated term to add to the taxonomy.
     * @param $textDomain
     * @return void
     */
    private function insertTerm($term, $textDomain)
    {
        /** @var string $taxonomySlug Used to bring the property into the scope of the anonymous function. */
        $taxonomySlug = $this->slug;

        add_action(
            'init',
            function () use ($term, $taxonomySlug, $textDomain) {
                $args = array('slug' => sanitize_title($term));
                wp_insert_term(__($term, $textDomain), $taxonomySlug, $args);
            }
        );
    }
} 
