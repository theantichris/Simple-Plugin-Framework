<?php

namespace theantichris\SPF;

class MetaBoxViewHelper
{

    public static $prefix = 'spf-meta-';

    /**
     * Outputs a text HTML input field.
     *
     * @since 5.0.0
     *
     * @param string $name Display name for the input field. Used as the label.
     * @param string $slug Unique identifier for the input field.
     * @return void
     */
    public static function CreateTextInput($name, $slug)
    {
        $viewData = array(
            'name' => $name,
            'slug' => $slug,
        );

        View::render(__DIR__ . '/ViewHelpers/MetaBoxTextInput.php', $viewData);
    }
} 