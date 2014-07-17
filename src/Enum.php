<?php

namespace theantichris\SPF;

/**
 * Class Enum
 *
 * Base class for creating enums.
 *
 * @package theantichris\SPF
 * @since 3.0.0
 */
abstract class Enum
{
    /**
     * Checks if a given value is a valid member of the fake enum.
     *
     * @since 3.0.0
     *
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        return defined("self::{$value}");
    }
}