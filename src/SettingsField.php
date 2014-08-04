<?php

namespace theantichris\SPF;

/**
 * Class SettingsField
 * @package theantichris\SPF
 * @since 2.0.0
 */
class SettingsField extends WordPressObject
{
    /** @var string An identifier that will be prefixed to the ID to prevent naming conflicts in the database. */
    private $prefix;

    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the field. Used to generate the slug.
     * @param string $prefix An identifier that will be prefixed to the ID to prevent naming conflicts in the database.
     * @param string $viewFile The full path to the view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    public function __construct($name, $prefix, $viewFile, $viewData = array())
    {
        $this->prefix           = $prefix;
        $this->name             = $name;
        $this->viewData         = $viewData;
        $this->viewFile         = $viewFile;
        $this->viewData['name'] = $this->getName();
        $this->viewData['slug'] = $this->getSlug();
    }

    /**
     * Returns a the sanitized name appended with the prefix.
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->prefix . '-' . sanitize_title($this->name);
    }
} 