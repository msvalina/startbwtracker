<?php
/**
 * Progression controller logic
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace MindfulMonkey\Startbwtracker\controllers;

use MindfulMonkey\Library\SessionController;
use MindfulMonkey\Startbwtracker\models\ProgressionModel;

/**
 * ProgressionController Class
 *
 * @package    Startbwtracker
 * @subpackage Library
 */
class ProgressionController extends SessionController
{
    protected $progression;

    public function __construct()
    {
        parent::__construct();
        $this->progression = new ProgressionModel();
    }
    public function index()
    {
        echo "Woot wot,, Progression wot,";
        echo '<br>';
        echo $param;
    }

    public function show($params)
    {
        parent::show($params);
        echo "<br> progresion show";
        var_dump($this->_fakeobje);
        $id = reset($params);
        $this->progression->getLastById($id);
    }
}
