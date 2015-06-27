<?php
/**
 * To be defined...
 * only for static pages?!
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace MindfulMonkey\Startbwtracker\controllers;

use MindfulMonkey\Library\BaseController;

/**
 * Class Home
 * @author John Doe
 */
class HomeController extends BaseController
{
    public function index()
    {
        echo 'home/index';
        parent::index();
    }
}
