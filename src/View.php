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
     * @param string $viewFile The full path to the view file.
     * @param mixed[] $viewData An array of data to pass to the view file.
     * @return void
     */
    public static function render($viewFile, $viewData)
    {
        if ($viewData) {
            extract($viewData);
        }

        // TODO: Try without output buffer.

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include($viewFile);

        /** @var string $template Contains the contents of the output buffer. */
        $template = ob_get_contents();

        ob_end_clean();

        echo $template;
    }
}
