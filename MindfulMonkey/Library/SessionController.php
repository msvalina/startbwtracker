<?php
/**
 * Common functions for all controllers that need session
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
 * Abstract class SessionController
 *
 * @package    Startbwtracker
 * @subpackage Library
 */

abstract class SessionController extends BaseController
{
    /**
     * Actions that need to be executed for all methods
     */
    public function __construct()
    {
        // Call BaseController's constructor
        parent::__construct();
        session_start();
        echo "sesssioooon controller <br>";
    }


}
