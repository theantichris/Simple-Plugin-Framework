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
    private $taxonomyName;
    /** @var string WordPress ID for the taxonomy. */
    private $taxonomySlug;
    /** @var array|string What post types the taxonomy will be registered to. */
    private $postTypes = 'post';
    /** @var array Arguments to pass to register_taxonomy(). */
    private $taxonomyArgs;
    /** @var array UI labels for the taxonomy. */
    private $taxonomyLabels;
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param string $taxonomyName User readable name for the taxonomy.
     * @param string|array|null $postTypes What post types to register the taxonomy with.
     * @param string $textDomain Text domain for the plugin.
     *
     * @return Taxonomy
     */
    public function __construct($taxonomyName, $postTypes = null, $textDomain = "")
    {
        $this->taxonomyName = $taxonomyName;
        $this->taxonomySlug = sanitize_title($taxonomyName);

        // If $postTypes is specified, set it. Otherwise it will default to 'post'.
        if (!empty($postTypes)) {
            $this->postTypes = $postTypes;
        }

        $this->textDomain = $textDomain;

        /** @var string $singular Singular version of $taxonomyName. */
        $singular = Utilities::makeSingular($taxonomyName);

        $this->taxonomyLabels = array(
            'name' => __($taxonomyName, $this->textDomain),
            'singular_name' => __($singular, $this->textDomain),
            'search_items' => __('Search ' . $taxonomyName, $this->textDomain),
            'all_items' => __('All ' . $taxonomyName, $this->textDomain),
            'parent_item' => __('Parent ' . $singular, $this->textDomain),
            'parent_item_colon' => __('Parent ' . $singular . ':', $this->textDomain),
            'edit_item' => __('Edit ' . $singular, $this->textDomain),
            'update_item' => __('Update ' . $singular, $this->textDomain),
            'add_new_item' => __('Add New ' . $singular, $this->textDomain),
            'new_item_name' => __('New ' . $singular . ' Name', $this->textDomain),
            'menu_name' => __($singular, $this->textDomain),
        );

        $this->taxonomyArgs = array(
            'labels' => $this->taxonomyLabels
        );

        add_action('init', array($this, 'registerCustomTaxonomy'));
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
        if (!taxonomy_exists($this->taxonomySlug)) {
            register_taxonomy($this->taxonomySlug, $this->postTypes, $this->taxonomyArgs);
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
        $taxonomySlug = $this->taxonomySlug;

        add_action(
            'init',
            function () use ($term, $taxonomySlug) {
                $args = array('slug' => sanitize_title($term));
                wp_insert_term(__($term, $this->textDomain), $taxonomySlug, $args);
            }
        );
    }
} 