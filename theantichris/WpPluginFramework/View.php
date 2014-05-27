<?php

namespace theantichris\WpPluginFramework;

/**
 * Class View
 *
 * A view model class.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class View
{
    private $view_file;
    public $view_data;

    /**
     * @param string $view_file
     * @param mixed[]|null $view_data
     */
    public function __construct($view_file, $view_data = null)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    /**
     * Extracts any view data that is part of the view then saves the view file to a string with any processed data.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function render()
    {
        // Check if any data was sent.
        if ($this->view_data) {
            extract($this->view_data);
        }

        ob_start(); // Start the output buffer.

        /** @noinspection PhpIncludeInspection */
        include_once($this->view_file); // Include the template.

        /** @var string $template Contains the contents of the output buffer. */
        $template = ob_get_contents(); // Add the template contents to the output buffer.

        ob_end_clean(); // End the output buffer.

        echo $template;
    }
}
