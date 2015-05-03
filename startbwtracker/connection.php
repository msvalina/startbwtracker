<?php
/**
 * Simple Database singelton class
 *
 * PHP version 5.6
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Startbwtracker\Connection;

/**
 * Database singelton class for returing instance of PDO object
 *
 * @package Startbwtracker
 */
class Database
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = 'mantis5c';
    const DBNAME = 'startbwtracker';

    private static $_instance = null;

    /**
     * Overriding constructor so that nobody else can instanciate it
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Overriding __clone so that nobody else can clone it
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Get instance of PDO object
     *
     * @return PDO instance
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            $pdo_options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
            $dbname = self::DBNAME;
            $host = self::HOST;
            self::$_instance = new PDO(
                "mysql:host=$host;dbname=$dbname", self::USER,
                self::PASSWORD, $pdo_options
            );
        }
        return self::$_instance;
    }
}
