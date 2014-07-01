<?php

namespace theantichris\WpPluginFramework;

/**
 * Class WordPressObject
 * @package theantichris\WpPluginFramework
 * @since 3.0.0
 *
 * TODO: Change name.
 */
abstract class WordPressObject
{
    /** @var string The text domain used for i18n. */
    public static $textDomain;

    /**
     * Takes a plural string and returns the singular version.
     *
     * Solution found at https://sites.google.com/site/chrelad/notes-1/pluraltosingularwithphp.
     *
     * @since 3.0.0
     *
     * @param string $word Plural word to make singular.
     *
     * @return string
     */
    protected function makeSingular($word)
    {
        /** @var mixed[] $rules Rules for making a string singular. The key is the plural ending, the value is the singular ending. */
        $rules = array(
            'ss'  => false,
            'os'  => 'o',
            'ies' => 'y',
            'xes' => 'x',
            'oes' => 'o',
            'ves' => 'f',
            's'   => ''
        );

        /** @var string $key */
        foreach (array_keys($rules) as $key) {
            if (substr($word, (strlen($key) * -1)) != $key) {
                continue;
            }

            if ($key === false) {
                return $word;
            }

            return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key];
        }

        return $word;
    }

    /**
     * Passes a name through WordPress' sanitize_title() method to create a slug.
     * @link http://codex.wordpress.org/Function_Reference/sanitize_title
     *
     * @since 3.0.0
     *
     * @param string $name
     * @return string
     */
    protected function getSlug($name)
    {
        return sanitize_title($name);
    }
}