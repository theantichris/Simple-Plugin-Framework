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
    /** @var string WordPress ID for the taxonomy. */
    private $slug;
    /** @var array|string What post types the taxonomy will be registered to. */
    private $postTypes;
    /** @var array UI labels for the taxonomy. */
    private $labels;
    /** @var array Arguments to pass to register_taxonomy(). */
    private $arguments;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param TaxonomyArg $taxonomyArg
     */
    public function __construct(TaxonomyArg $taxonomyArg)
    {
        $this->name      = $taxonomyArg->getName();
        $this->slug      = $taxonomyArg->getSlug();
        $this->postTypes = $taxonomyArg->postTypes;
        $this->labels    = $taxonomyArg->getLabels();

        $this->setArguments();

        add_action('init', array($this, 'registerCustomTaxonomy'));
    }

    /**
     * @since 1.2.0
     */
    private function setArguments()
    {
        $this->arguments = array(
            'labels' => $this->labels,
        );
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
            register_taxonomy($this->slug, $this->postTypes, $this->arguments);
        }
    }

    /**
     * Validates a term or list of terms to add to the taxonomy then calls insertTerm() to add it to the database.
     *
     * @since 0.1.0
     *
     * @param string|array $terms Terms to add to the taxonomy.
     *
     * @return void
     */
    public function addTerms($terms)
    {
        if (is_array($terms)) {
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if ('' != trim($term)) {
                        $this->insertTerm(trim($term));
                    }
                }
            }
        } else {
            if ('' != trim($terms)) {
                $this->insertTerm(trim($terms));
            }
        }
    }

    /**
     * Adds a term to the WordPress database after being validated by addTerms().
     *
     * @since 0.1.0
     *
     * @param string $term Validated term to add to the taxonomy.
     *
     * @return void
     */
    private function insertTerm($term)
    {
        /** @var string $taxonomySlug Used to bring the property into the scope of the anonymous function. */
        $taxonomySlug = $this->slug;

        add_action(
            'init',
            function () use ($term, $taxonomySlug) {
                $args = array('slug' => sanitize_title($term));
                wp_insert_term(__($term, $this->textDomain), $taxonomySlug, $args);
            }
        );
    }
} 
