<?php

namespace theantichris\SPF;

/**
 * Class SettingsField
 * @package theantichris\SPF
 * @since 2.0.0
 */
class SettingsField extends WordPressObject
{
    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the field. Used to generate the slug.
     * @param string $slug Unique identifier for the object in the WordPress database.
     * @param string $viewFile The full path to the view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    public function __construct($name, $slug, $viewFile, $viewData = array())
    {
        $this->name             = $name;
        $this->slug             = $slug;
        $this->viewData         = $viewData;
        $this->viewFile         = $viewFile;
        $this->viewData['name'] = $this->getName();
        $this->viewData['slug'] = $this->getSlug();
    }
} 