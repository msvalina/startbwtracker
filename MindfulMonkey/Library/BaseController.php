<?php
/**
 * Parent abstract class for all controllers
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
 * Abstract class BaseController
 *
 * @package    Startbwtracker
 * @subpackage Library
 */
abstract class BaseController
{
    abstract public function index();

}
