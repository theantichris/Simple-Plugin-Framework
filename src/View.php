<?php

namespace theantichris\SPF;

/**
 * Class View
 * @package theantichris\SPF
 * @since 0.1.0
 */
class View
{
    /**
     * Passes data into and renders a view file.
     *
     * @since 0.1.0
     * @param $viewFile
     * @param $viewData
     * @return void
     */
    public static function render($viewFile, $viewData)
    {
        if ($viewData) {
            extract($viewData);
        }

        ob_start(); // Start the output buffer.

        /** @noinspection PhpIncludeInspection */
        include($viewFile); // Include the template.

        /** @var string $template Contains the contents of the output buffer. */
        $template = ob_get_contents(); // Add the template contents to the output buffer.

        ob_end_clean(); // End the output buffer.

        echo $template;
    }
}
