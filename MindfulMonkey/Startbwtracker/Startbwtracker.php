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

use MindfulMonkey\Startbwtracker\controllers\ExerciseController;

/**
 * Class Startbwtracker
 * @author Marijan Svalina
 */
class Startbwtracker
{

    protected $controller = 'home';

    protected $view = 'index';

    protected $params = [];

    /**
     * @param mixed
     */
    public function __construct($target)
    {
        $sesCtrl = new ExerciseController;
        $sesCtrl->index();

    }

}
