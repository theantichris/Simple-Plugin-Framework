<?php
/**
 * Class WordPress_Plugin_Framework
 *
 * @package    WordPress
 * @subpackage WordPressPluginFramework
 *
 * @since      1.0.0
 */
class WordPress_Plugin_Framework {
    /** @var null|WordPress_Plugin_Framework Refers to a single instance of this class. */
    private static $instance = null;

    /**
     * Creates or returns an instance of this class.
     *
     * @since 1.0.0
     *
     * @return WordPress_Plugin_Framework A single instance of this class.
     */
    public static function get_instance() {
        // If an instance hasn't been create and set to $instance create an instance and set it to $instance.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Initializes the plugin by setting localization, hooks, filters, and administrative functions.
     *
     * @since 1.0.0
     *
     * @return WordPress_Plugin_Framework
     */
    private function __construct() {
        include_once 'custom-post-type.php';
        include_once 'page.php';
        include_once 'menu-page.php';
        include_once 'object-page.php';
        include_once 'options-page.php';
        include_once 'sub-menu-page.php';
        include_once 'utility-page.php';
        include_once 'settings.php';
        include_once 'taxonomy.php';
        include_once 'view.php';
    }

    /**
     * Takes a plural string and returns the singular version.
     *
     * Solution found at https://sites.google.com/site/chrelad/notes-1/pluraltosingularwithphp.
     *
     * @since 2.0.0
     *
     * @param string $word Plural string to make singular.
     *
     * @return string
     */
    public static function make_singular( $word ) {
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

            if ( substr( $word, ( strlen( $key ) * -1 ) ) != $key ) {
                continue;
            }

            // If the value of the key is false, stop looping and return the original version of the word.
            if ( $key === false ) {
                return $word;
            }

            // We've made it this far, so we can do the replacement.
            return substr( $word, 0, strlen( $word ) - strlen( $key ) ) . $rules[ $key ];
        }

        return $word;
    }

    /**
     * Makes WordPress slug by making the string lowercase and replacing spaces with hyphens.
     *
     * @since 3.1.0
     *
     * @param $string String to make a slug out of.
     *
     * @return string
     */
    public static function make_slug( $string ) {
        return str_replace( ' ', '-', strtolower( $string ) );
    }
}

WordPress_Plugin_Framework::get_instance();