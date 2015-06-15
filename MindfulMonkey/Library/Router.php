<?php
/**
 * Definition of Router class
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
 * Simple HTTP method and URL router
 *
 * @package    Startbwtracker
 * @subpackage Library
 */
class Router
{
    protected $routes = array();
    protected $baseName = null;

    /**
     * Router constructor
     *
     * @return void
     */
    public function __construct()
    {
        echo "My fancy router instance<br>";
        echo "yeahhh<br>";
    }

    /**
     * Map URL routes to controller and action 
     *
     * @param string $method  HTTP method
     * @param string $pattern regex pattern that uniquely identifies $target
     * @param string $target  controller and action in form of
     *                        controller#action
     * 
     * @return void
     */
    public function map($method, $pattern, $target)
    {
        $route = array (
            "method" => $method,
            "pattern" => $pattern,
            "target" => $target
        );

        array_push($this->routes, $route);

    }

    /**
     * Match incomig URL request with mapped routes
     * 
     * @return array target with target and regex named subpatterns
     */
    public function match()
    {
        /* print_r($this->routes); */
        $target = array();

        if ($_SERVER['REQUEST_URI']) {
            echo "Searching for: <br>";
            var_dump($_SERVER['REQUEST_URI']);
            $uri = $_SERVER['REQUEST_URI'];
            echo "<br>";
            if (!$this->baseName == null) {
                $uri = preg_replace($this->baseName, '', $uri);
            }
            var_dump($uri);
            echo "<br>";
            echo "<br>";
            foreach ($this->routes as $rt) {
                if ($rt["method"] == $_SERVER['REQUEST_METHOD'] ) {
                    $isSuportedMethod = true;
                } else {
                    continue;
                }
                if ($isSuportedMethod) {
                    var_dump($rt["pattern"]);
                    $preg_match = preg_match($rt["pattern"], $uri, $matches);
                    var_dump($preg_match);
                    if ($preg_match === 1 ) {
                        echo 'this is matches <br>';
                        var_dump($matches);
                        $target["target"] = $rt["target"];
                        foreach ($matches as $key => $value) {
                            if (!is_numeric($key)) {
                                $target[$key] = $value;
                            }
                        }
                        // Exit as soon as match is found
                        break;
                    }
                }
                echo "<br> Next match <br>";
            }
        }
        echo '<br> dumping target <br>';
        var_dump($target);

        return $target;
    }

    /**
     * Set base name of URL which will be truncated
     *
     * @param string $name base name
     *
     * @return void
     **/
    public function setBase($name)
    {
        $this->baseName = $name;
    }
    
} 
