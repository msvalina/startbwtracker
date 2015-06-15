<?php

require_once 'autoload.php';

use \MindfulMonkey\Startbwtracker;
use \MindfulMonkey\Library\Router;

$router = new Router();

$router->map('GET', '~^/?$~', 'home#index');
$router->map('GET', '~/home/?$~', 'home#index');
$router->map('GET', '~/workout/?$~', 'workout#index');

// Display list of all progressions
$router->map('GET', '~^/progression/?$~', 'progression#index');
// Return an HTML form for creating a new progression
$router->map('GET', '~^/progression/new/?$~', 'progression#new');
// Create a new progression
$router->map('POST', '~^/progression/?$~', 'progression#create');
// Display specific progression
$router->map('GET', '~^/progression/(?P<prg_id>\d+)/?$~', 'progression#show');
/* // Return HTML form for editing a specific progression */
$router->map('GET', '~^/progression/(?P<prg_id>\d+)/edit/?$~', 'progression#edit');
/* // Update a specific progression */
$router->map('PUT', '~^/progression/(?P<prg_id>\d+)/?$~', 'progression#update');
/* // Delete a specific progression */
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

$router->setBase('~/startbwtracker~');
$target = $router->match();

$app = new Startbwtracker\Startbwtracker($target);

