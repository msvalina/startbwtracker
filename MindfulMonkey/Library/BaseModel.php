<?php
/**
 * Common methods for all Models
 *
 * PHP version 5.4 and above
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace MindfulMonkey\Library;

use MindfulMonkey\Library\Database;

/**
 * Abstract class for all models
 *
 * @package Startbwtracker
 * @subpackage Library
 */
abstract class BaseModel
{
    public $db;

    /**
     * Get db object
     *
     * @return void
     * @author Marijan Svalina
     */
    public function __construct()
    {
        $this->db = Database::getDatabaseObject();
    }

    /**
     * Get progression by id from db
     *
     * @param int $id Id of the progression
     *
     * @return array $progression
     */
    public function getLastById($id)
    {
        $stmt = $this->db->query("SELECT * FROM `Progression` WHERE id=$id");
        var_dump($stmt);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<br>";
            echo $row['id'].' '.$row['name'].' '; //etc...
        }

    }
}
