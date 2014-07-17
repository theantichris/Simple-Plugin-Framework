<?php

namespace theantichris\SPF;

/**
 * Class SettingsSection
 * @package theantichris\SPF
 * @since 2.0.0
 */
class SettingsSection extends WordPressObject
{
    /** @var string Title of the section. Used to generate the slug. */
    protected $name;
    /** @var View|null The View object responsible for rendering the field's HTML. */
    private $view;
    /** @var SettingsField[] An array of settings fields added to the section. */
    private $settingsFields = array();

    /**
     * Assigns properties and sets up the view.
     *
     * @since 2.0.0
     *
     * @param string $name Title of the section. Used to generate the slug.
     * @param View|null $view The View object responsible for rendering the field's HTML.
     */
    public function __construct($name, $view = null)
    {
        $this->name = $name;

        if (!empty($view)) {
            $this->view                   = $view;
            $this->view->viewData['name'] = $this->getName();
        }
    }

    /**
     * Renders the sections HTML.
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

        $this->view->render();
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