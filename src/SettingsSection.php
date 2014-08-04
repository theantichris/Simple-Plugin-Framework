<?php

namespace theantichris\SPF;

/**
 * Class SettingsSection
 * @package theantichris\SPF
 * @since 2.0.0
 */
class SettingsSection extends WordPressObject
{
    /** @var SettingsField[] An array of settings fields added to the section. */
    private $settingsFields = array();

    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the section. Used to generate the slug.
     * @param string $viewFile The full path to the view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     */
    public function __construct($name, $viewFile, $viewData = array())
    {
        $this->name = $name;

        if (!empty($view)) {
            $this->view             = $view;
            $this->viewData         = $viewData;
            $this->viewData['name'] = $this->getName();
        }
    }

    /**
     * Override of the parent class display() method.
     * Should not be called directly. It is only public so WordPress can call it.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function display()
    {
        if (empty($this->view)) {
            return;
        }

        View::render($this->viewFile, $this->viewData);
    }

    /**
     * Sends SettingsField objects to addField().
     *
     * @since 3.0.0
     *
     * @param SettingsField|SettingsField[] $fields SettingsField objects to add to the section.
     * @return $this
     */
    public function addFields($fields)
    {
        if (is_array($fields)) {
            /** @var SettingsField $field */
            foreach ($fields as $field) {
                $this->addField($field);
            }
        } else {
            $this->addField($fields);
        }

        return $this;
    }

    /**
     * Adds a SettingsField to this SettingsSection if it does not already exist.
     *
     * @since 3.0.0
     *
     * @param SettingsField $field The SettingsField object to add to the section.
     * @return void
     */
    private function addField(SettingsField $field)
    {
        if (array_key_exists($field->getSlug(), $this->settingsFields)) {
            wp_die(__("A field with ID {$field->getSlug()} was already added to the settings section {$this->getSlug()} page.", parent::$textDomain));
        } else {
            $this->settingsFields[$field->getSlug()] = $field;
        }
    }

    /**
     * Returns $fields.
     *
     * @since 3.0.0
     *
     * @return SettingsField[]
     */
    public function getFields()
    {
        return $this->settingsFields;
    }
} 