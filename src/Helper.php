<?php

namespace theantichris\SPF;

/**
 * A class of static utility methods.
 *
 * @package theantichris\SPF
 * @since   4.0.0
 */
class Helper {
	/**
	 * Takes a plural string and returns the singular version.
	 *
	 * @link  https://sites.google.com/site/chrelad/notes-1/pluraltosingularwithphp
	 *
	 * @since 3.0.0
	 *
	 * @param string $word Plural word to make singular.
	 *
	 * @return string
	 */
	public static function makeSingular( $word ) {
		/** @var mixed[] $rules Rules for making a string singular. The key is the plural ending, the value is the singular ending. */
		$rules = array(
			'ss'  => false,
			'os'  => 'o',
			'ies' => 'y',
			'xes' => 'x',
			'oes' => 'o',
			'ves' => 'f',
			'es'  => '',
			's'   => '',
		);

		/** @var string $key */
		foreach ( array_keys( $rules ) as $key ) {
			if ( substr( $word, ( strlen( $key ) * - 1 ) ) != $key ) {
				continue;
			}

			if ( $key === false ) {
				return $word;
			}

			return substr( $word, 0, strlen( $word ) - strlen( $key ) ) . $rules[ $key ];
		}

		return $word;
	}
} 