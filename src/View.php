<?php

namespace theantichris\SPF;

/**
 * Class View
 * @package theantichris\SPF
 * @since 0.1.0
 */
class View
{
    /** @var string Full path to the view file. */
    private $viewFile;
    /** @var \mixed[] Any data the view needs to know about. */
    public $viewData;

    /**
     * @since 2.0.0
     * @param string $viewFile
     * @param mixed[]|null $viewData
     * @param string $textDomain
     */
    public function __construct($viewFile, $viewData = array(), $textDomain = '')
    {
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
    }

    /**
     * @since 0.1.0
     * @return void
     */
    public function render()
    {
        if ($this->viewData) {
            extract($this->viewData);
        }

        ob_start(); // Start the output buffer.

        /** @noinspection PhpIncludeInspection */
        include($this->viewFile); // Include the template.

        /** @var string $template Contains the contents of the output buffer. */
        $template = ob_get_contents(); // Add the template contents to the output buffer.

        ob_end_clean(); // End the output buffer.

        echo $template;
    }
}
