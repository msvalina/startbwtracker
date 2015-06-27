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
    public function index()
    {
        echo "<br> abstracted index";
    }

    public function newMethod()
    {
        echo "<br> abstracted new";
    }

    public function create()
    {
        echo "<br> abstracted create";
    }

    public function show()
    {
        echo "<br> abstracted show";
    }

    public function edit()
    {
        echo "<br> abstracted edit";
    }

    public function update()
    {
        echo "<br> abstracted update";
    }

    public function deleteMethod()
    {
        echo "<br> abstracted delete";
    }
}
