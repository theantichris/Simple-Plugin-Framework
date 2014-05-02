<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Utilities
 *
 * A static class with utility methods other classes need.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class Utilities {

    /**
     * Takes a plural string and returns the singular version.
     *
     * Solution found at https://sites.google.com/site/chrelad/notes-1/pluraltosingularwithphp.
     *
     * @since 0.1.0
     *
     * @param string $word Plural string to make singular.
     *
     * @return string
     */
    public static function makeSingular( $word ) {
        /** @var array[string|bool] $rules Rules for making a string singular. */
        $rules = array(
            'ss'  => false,
            'os'  => 'o',
            'ies' => 'y',
            'xes' => 'x',
            'oes' => 'o',
            'ves' => 'f',
            's'   => ''
        );

        // Loop through all the rules and do the replacement.
        foreach ( array_keys( $rules ) as $key ) {
            // If the end of the word doesn't match the key, it's not a candidate for replacement. Move on to the next plural ending.
            if ( substr( $word, ( strlen( $key ) * -1 ) ) != $key )
                continue;

            // If the value of the key is false, stop looping and return the original version of the word.
            if ( $key === false )
                return $word;

            // We've made it this far, so we can do the replacement.
            return substr( $word, 0, strlen( $word ) - strlen( $key ) ) . $rules[ $key ];
        }

        return $word;
    }
}