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
    /**
     * A static function that allows rendering of a HTML template from anywhere within a plugin.
     *
     * @since 0.1.0
     *
     * @param string $view_file The full path to the view file.
     * @param array $view_data An associative array of variables that the view needs.
     *
     * @return string
     */
    public static function render($view_file, $view_data = null)
    {
        // Check if any data was sent.
        if ($view_data) {
            extract($view_data);
        }

        ob_start(); // Start the output buffer.

        /** @noinspection PhpIncludeInspection */
        include_once($view_file); // Include the template.

        /** @var string $template Contains the contents of the output buffer. */
        $template = ob_get_contents(); // Add the template contents to the output buffer.

        ob_end_clean(); // End the output buffer.

        return $template;
    }
}