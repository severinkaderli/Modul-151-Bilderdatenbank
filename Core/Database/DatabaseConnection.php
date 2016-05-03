<?php

namespace Core\Database;

/**
 * @author Severin Kaderli
 */
class DatabaseConnection
{

    /**
     * @var \PDO
     */
    private static $pdo;

    /**
     * Connecting to a database.
     *
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbHost
     * @param string $dbName
     */
    public static function init($dbUser, $dbPass, $dbHost, $dbName)
    {
        $dns = 'mysql:host=' . $dbHost . ';port=3306;dbname=' . $dbName;

        self::$pdo = new \PDO($dns, $dbUser, $dbPass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    /**
     * @param string $query
     * @param array $parameter
     * @return array
     */
    public static function getResult($query, array $parameter = [])
    {
        $result = [];
        try {
            //Prepare the statement and bind values
            $stmt = self::$pdo->prepare($query);
            $stmt->execute($parameter);

            while ($row = $stmt->fetchObject()) {
                $result[] = $row;
            }

            return $result;
        } catch(\Exception $e) {
            echo $e->getMessage();
            echo "<br>";
            echo $query;
            echo "<br>";
            echo $e->getFile() . " on Line: " . $e->getLine();
        }
    }

    public static function insert($query, array $parameter = [])
    {
        //Prepare the statement and bind values
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($parameter);
    }

}