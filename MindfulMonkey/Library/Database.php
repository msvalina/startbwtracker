<?php
/**
 * Database configuration and initialization
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
 * Class Database
 *
 * @package Startbwtracker
 */
class Database
{
    /**
     * Initialize, configure and retrun database object
     *
     * @return PDO $db
     **/
    static public function getDatabaseObject()
    {
        if (getenv("OPENSHIFT_MYSQL_DB_HOST") === false) {
            $_host = "localhost";
            $_username = "root";
            $_password = "mantis5c";
            $_database = "startbwtracker";
        } else {
            $_host = getenv("OPENSHIFT_MYSQL_DB_HOST");
            $_username = getenv("OPENSHIFT_MYSQL_DB_USERNAME");
            $_password = getenv("OPENSHIFT_MYSQL_DB_PASSWORD");
            $_database = "startbwtracker";
        }

        $db = new \PDO(
            "mysql:host=$_host;dbname=$_database;", $_username, $_password
        );
        // set the PDO error mode to exception
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
