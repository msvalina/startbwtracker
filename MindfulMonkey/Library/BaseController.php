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
    /**
     * Controllers constructor
     *
     * @return void
     */
    public function __construct()
    {
        echo 'Testing BaseController constructor <br>';

    }
    /**
     * Display a list of models entries
     *
     * @return void
     */
    public function index()
    {
        echo "<br> abstracted index";
    }

    /**
     * Return HTML form for model entry
     *
     * @return void
     */
    public function newMethod()
    {
        echo "<br> abstracted new";
    }


    /**
     * Create new model entry
     *
     * @return void
     */
    public function create()
    {
        echo "<br> abstracted create";
    }

    /**
     * Show specific model entry
     *
     * @return void
     */
    public function show($params)
    {
        echo '<br>';
        var_dump($params);
        $id = reset($params);
        echo "<br> abstracted show:$id";

    }

    /**
     * Return HTML form for editing a specific model entry
     *
     * @return void
     */
    public function edit()
    {
        echo "<br> abstracted edit";
    }

    /**
     * Update a specific model entry
     *
     * @return void
     */
    public function update()
    {
        echo "<br> abstracted update";
    }

    /**
     * Delete a specific model entry
     *
     * @return void
     */
    public function deleteMethod()
    {
        echo "<br> abstracted delete";
    }
}
