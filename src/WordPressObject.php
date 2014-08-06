<?php

namespace theantichris\SPF;

/**
 * Class WordPressObject
 * @package theantichris\SPF
 * @since 3.0.0
 */
abstract class WordPressObject
{
    /** @var string The text domain used for i18n. */
    public static $textDomain = 'default';
    /** @var string Name or title of the WordPress object. */
    protected $name;
    /** @var string Unique identifier for the object in the WordPress database. */
    protected $slug;
    /** @var string The full path to the object's view file. */
    protected $viewFile;
    /** @var mixed[] An array of data to pass to the view file. */
    protected $viewData;

    /**
     * Returns the object's $name property.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getName()
    {
        return __($this->name, self::$textDomain);
    }

    /**
     * Passes a $name through WordPress' sanitize_title() method to create a slug.
     * @link http://codex.wordpress.org/Function_Reference/sanitize_title
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Default display callback for WordPress objects.
     * Do not call directly, it is only public so WordPress can call it.
     *
     * @since 4.0.0
     *
     * @return void
     */
    public function display()
    {
        View::render($this->viewFile, $this->viewData);
    }
}