<?php
/**
 * Initial application configuration, autoloading and routing logic
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

require_once 'autoload.php';

use \MindfulMonkey\Startbwtracker;
use \MindfulMonkey\Library\Router;
use \MindfulMonkey\Library\Helper;

$router = new Router();

/**
 * @todo Move all route mapings to a new file
 * @todo Transfer delimiter to routers map method
 */
$router->map('GET', '~^/?$~', 'home#index');
$router->map('GET', '~/home/?$~', 'home#index');
$router->map('GET', '~/workout/?$~', 'workout#index');

// Display list of all progressions
$router->map('GET', '~^/progression/?$~', 'progression#index');
// Return an HTML form for creating a new progression
$router->map('GET', '~^/progression/new/?$~', 'progression#new');
// Create a new progression
$router->map('POST', '~^/progression/?$~', 'progression#create');
// Display specific progression match it either by id or name
$router->map(
    'GET', '~^/progression/(?P<prg_id>\d+)|(?P<prg_name>[\w ]+)/?$~',
    'progression#show'
);
// Return HTML form for editing a specific progression
$router->map('GET', '~^/progression/(?P<prg_id>\d+)/edit/?$~', 'progression#edit');
// Update a specific progression
$router->map('PUT', '~^/progression/(?P<prg_id>\d+)/?$~', 'progression#update');
// Delete a specific progression
$router->map('DELETE', '~^/progression/(?P<prg_id>\d+)/?$~', 'progression#delete');

// Display a list of all exercise sessions
$router->map('GET', '~^/exercise/?$~', 'exercise#index');
// Return a HTML form for choosing progression types for new exercise session
$router->map('GET', '~^/exercise/new/?$~', 'exercise#new');
// Create a new exercise session
$router->map('POST', '~^/exercise/?$~', 'exercise#create');
// Display a specific exercise session
$router->map('GET', '~^/exercise/(?P<ex_id>\d+)/?$~', 'exercise#show');
// Return HTML form for update a specific exercise session
$router->map('GET', '~^/exercise/(?P<ex_id>\d+)/edit/?$~', 'exercise#edit');
// Update a specific exercise session
$router->map('PUT', '~^/exercise/(?P<ex_id>\d+)/?$~', 'exercise#update');
// Delete a specific exercise session
$router->map('DELETE', '~^/exercise/(?P<ex_id>\d+)/?$~', 'exercise#delete');

// On localhost app is in DocumentRoot/startbwtracker
if (Helper::isLocalhost()) {
    $router->setBase('~/startbwtracker~');
}

$matchedRoute = $router->match();

// Set default controller and method if router did not find match
if (empty($matchedRoute)) {
    $matchedRoute[target]= "home#index";
}

$app = new Startbwtracker\Startbwtracker($matchedRoute);
