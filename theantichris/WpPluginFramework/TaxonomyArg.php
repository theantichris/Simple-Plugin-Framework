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
    /** @var string WordPress ID for the taxonomy. */
    private $slug;
    /** @var array|string What post types the taxonomy will be registered to. */
    public $postTypes = 'post';
    /** @var array UI labels for the taxonomy. */
    private $labels;
    /** @var  string $textDomain Text domain for the plugin. */
    private $textDomain;

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

    private function setLabels()
    {
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