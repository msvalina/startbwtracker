<?php
/**
 * Parse target and call controller and method
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace MindfulMonkey\Startbwtracker;

/**
 * Class Startbwtracker
 *
 * @package Startbwtracker
 */
class Startbwtracker
{

    /**
     * Parsed controller from matchedRoute
     *
     * @var string
     */
    private $_controller;

    /**
     * Parsed method from matchedRoute
     *
     * @var string
     */
    private $_method;

    /**
     * Array of regex named patterns from matchedRoute
     *
     * @var array $params
     */
    private $_params = [];

    /**
     * Call class methods
     *
     * @param array $matchedRoute passed to parseMatchedRoute
     */
    public function __construct($matchedRoute)
    {
        $this->parseMatchedRoute($matchedRoute);
        $this->callController();
    }

    /**
     * Parse matched array, set controller and method from target
     *
     * @param array $matchedRoute associative array in which first param is
     *                            string in form of "controller#method" and rest
     *                            are regex matched vars.
     *
     * @return void
     */
    public function parseMatchedRoute($matchedRoute)
    {
        $parts = explode('#', $matchedRoute["target"]);
        $this->_controller = $parts[0];

        // PHP does not support keywords like new and delete to be function
        // names so controller methods are called newMethod and deleteMethod
        if (($parts[1] === "new") || $parts[1] === "delete") {
            $this->_method = $parts[1] . 'Method';
        } else {
            $this->_method = $parts[1];
        }

        unset($matchedRoute["target"]);

        $this->_params = $matchedRoute;

    }

    /**
     * Build dynamicly controller, call it and pass params to method
     *
     * @return void
     */
    public function callController()
    {

        // autoload loads class only when it has global path if it is build
        // dynamicly
        $controller = '\\MindfulMonkey\\Startbwtracker\\controllers\\'
                      . ucfirst($this->_controller) . 'Controller';

        // For constructors of abstract classes to be called the controller
        // must be initiated
        $controllerObject = new $controller;

        call_user_func_array(
            array($controllerObject, $this->_method),
            array($this->_params)
        );
    }

}
