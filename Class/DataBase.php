<?php


class DataBase
{
    protected static $host="localhost";
    protected static $db="restaurant";
    protected static $instance;
    private static $dsn = 'mysql:host=localhost;dbname=restaurant';

    private static $username = 'root';

    private static $password = '';

    private function __construct() {
        try {
            self::$instance = new PDO(self::$dsn, self::$username, self::$password);
        } catch (PDOException $e) {
            echo "MySql Connection Error: " . $e->getMessage();
        }
    }

    public static function getConnection() {
        if (!self::$instance) {
            new DataBase();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public static function getHost()
    {
        return self::$host;
    }

    /**
     * @return string
     */
    public static function getUser()
    {
        return self::$username;
    }

    /**
     * @return string
     */
    public static function getPass()
    {
        return self::$password;
    }

    /**
     * @return string
     */
    public static function getDb()
    {
        return self::$db;
    }




}