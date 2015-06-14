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
    protected $baseName = null;

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
     * Match incomig url request with mapped routes
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
     * setBase
     * @return void
     * @author Marijan Svalina
     **/
    public function setBase($name)
    {
        $this->baseName = $name;
    }
    
} 
