<?php

namespace theantichris\WpPluginFramework;

    /*
     * How settings work in WordPress.
     *
     * 1. add_settings_section( $id = 'eg_setting_section', $title = 'Example settings section in reading', $callback = 'eg_setting_section_callback_function', $page = 'reading' )
     * 2. add_settings_field( $id = 'eg_setting_name', $title = 'Example setting Name', $callback = 'eg_setting_callback_function', $page = 'reading', $section = 'eg_setting_section', $args = array() )
     * 		$page should equal $page in add_settings_section()
     * 		$section should equal $id in add_settings_section()
     * 3. register_setting( $option_group = 'reading', $option_name = 'eg_setting_name', $sanitize_callback = null )
     * 		$option_group should equal the values for $page in the other functions
     * 		$option_name should equal $id in add_settings_field()
     */

/**
 * Class Settings
 *
 * A class for creating and managing settings in WordPress.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class Settings
{
    /** @var string The WordPress page slug the settings will appear on. */
    private $page;
    /** @var mixed[] Information about the settings section if used. */
    private $section;

    /**
     * Class constructor.
     *
     * @since 0.1.0
     *
     * @param SettingsArg $settingsArg
     */
    public function __construct(SettingsArg $settingsArg)
    {
        $this->page    = $settingsArg->getPage();
        $this->section = $settingsArg->getSection();
    }

    /**
     * Adds a settings section to the object.
     *
     * @since 0.1.0
     *
     * @param string $title User readable title for the settings section.
     * @param string $viewPath The full path to the settings section's view.
     * @param array $viewData Any data that needs to be passed to the view.
     *
     * @return void
     */
    public function addSection($title, $viewPath, $viewData = array())
    {
        if (('' != trim($title)) && (file_exists($viewPath))) {
            $this->section['title'] = $title;
            $this->section['id']    = sanitize_title($title);

            $this->section['viewPath']          = $viewPath;
            $this->section['viewData']          = $viewData;
            $this->section['viewData']['title'] = $title;

            add_action('admin_init', array($this, 'registerSection'));
        }
    }

    /**
     * Registers the settings section with WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function registerSection()
    {
        add_settings_section(
            $this->section['id'],
            $this->section['title'],
            array($this, 'displaySection'),
            $this->page
        );
    }

    /**
     * Displays the settings section output.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function displaySection()
    {
        echo View::render($this->section['viewPath'], $this->section['viewData']);
    }

    /**
     * Adds a settings field to the object.
     *
     * @since 0.1.0
     *
     * @param string $title User readable name for the field.
     * @param string $viewPath Path to the view for the field
     * @param array $viewData Data to pass to the view.
     * @param array $args Optional arguments the field needs in WordPress.
     *
     * @return void
     */
    public function addField($title, $viewPath, $viewData = array(), $args = array())
    {
        // Make sure both the title and view path are valid.
        if (('' != trim($title)) && (file_exists($viewPath))) {
            $page    = $this->page;
            $section = $this->section['id'];

            // Call hook to register the setting field with WordPress.
            add_action(
                'admin_init',
                function () use ($title, $viewPath, $viewData, $args, $page, $section) {
                    $id = sanitize_title($title);

                    // Add settings field.
                    add_settings_field(
                        $id,
                        $title,
                        function () use ($id, $title, $viewPath, $viewData) {
                            // Display the field's view.
                            $viewData['title'] = $title;
                            $viewData['id']    = $id;
                            echo View::render($viewPath, $viewData);
                        },
                        $page,
                        $section,
                        $args
                    );

                    // Register setting.
                    register_setting($page, $id);
                }
            );
        }
    }

    /**
     * Cleanly removes a setting from WordPress.
     *
     * @since 0.1.0
     *
     * @param string $page
     * @param string $id
     *
     * @return void
     */
    public function removeField($page, $id)
    {
        unregister_setting($page, $id);
    }
}
