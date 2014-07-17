<?php
/**
 * Created by PhpStorm.
 * User: christopher.lamm
 * Date: 7/17/14
 * Time: 12:02 PM
 */
namespace theantichris\SPF;


/**
 * Class Capability
 *
 * An enum of all valid WordPress capabilities.
 * @link http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
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
    public function isValid($value)
    {
        return defined("self::{$value}");
    }
}