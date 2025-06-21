<?php

namespace Connections;

use \Exception;
use \PDO;

require_once __DIR__ . '/../Database/Credential.inc';

class Connection
{
    private static $instance = null;
    private $conn;

    /**
     * Establish Connection
     * @throws \Exception
     */
    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPW);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (\PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    /**
     * Return Connection Instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance->conn;
    }
}