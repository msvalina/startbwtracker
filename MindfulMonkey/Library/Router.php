<?php

namespace MindfulMonkey\Library;

/**
 * Simple REST router
 *
 * @package    MindfulMonkey
 * @subpackage Library
 */
class Router
{
    protected $routes = array();
    protected $baseName;

    public function __construct()
    {
        echo "My fancy router instance<br>";
        echo "yeahhh<br>";
    }

    /**
     * Map url routes to controller and action 
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

        return null;
    }

    /**
     * Match incoming url request with mapped routes
     * 
     * @return string match
     */
    public function match()
    {
        /* print_r($this->routes); */
        $target = array();

        if ($_SERVER['REQUEST_URI']) {
            echo "Searching for: <br>";
            var_dump($_SERVER['REQUEST_URI']);
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];
            echo "<br>";
            $uri = preg_replace($this->baseName, '', $uri);
            var_dump($uri);
            echo "<br>";
            echo "<br>";
            foreach ($this->routes as $route) {
                foreach ($route as $key => $value) {
                    echo $key; echo ' => '; echo $value; echo "<br>";
                    if ($key == "method") {
                        if ($value == $method) {
                            $isSuportedMethod = true;
                        }
                        else {
                            break;
                        }
                    }
                    if ($key == "pattern" && $isSuportedMethod) {
                        $preg_match = preg_match($value, $uri, $matches);
                        var_dump($preg_match);
                        if ($preg_match === 1 ) {
                            echo '<br>';
                            var_dump($matches);
                            foreach ($matches as $key => $value) {
                                if (!is_numeric($key)) {
                                    $target[$key] = $value;
                                }
                            }
                        }
                    }
                    if ($key == "target" && $preg_match === 1) {
                        $target[$key] = $value;
                    }
                }
            }
        }
        echo '<br>';
        var_dump($target);

        return $target;
    }

    /**
     * setBase
     * @return void
     * @author Marijan Svalina
     **/
    public function setBase($name)
    {
        $this->baseName = $name;
    }
    
} 
