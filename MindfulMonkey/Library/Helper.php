<?php
/**
 * Various system and maintenance functions
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace MindfulMonkey\Library;

/**
 * Helper class with static methods
 *
 * @package    Startbwtracker
 * @subpackage Library
 */
class Helper
{

    /**
     * Check if we are running localy
     *
     * @return bool
     */
    public static function isLocalhost()
    {
        // if this is localhost
        return $_SERVER['SERVER_ADDR'] == '127.0.0.1' ||
            $_SERVER['SERVER_ADDR'] == '::1';
    }
}
