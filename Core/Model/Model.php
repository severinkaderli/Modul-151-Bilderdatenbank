<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;

/**
 * @author Severin Kaderli
 */
class Model
{

    /**
     * The database table for this model. This should be set in every model to
     * the correct table.
     *
     * @var string
     */
    static protected $table = "";

    /**
     * Model constructor.
     */
    public function __construct()
    {
    }


    /**
     * Finds and returns an Entity by its id
     *
     * @param int $id
     * @return self
     */
    public static function find($id)
    {
        echo static::$table;
        $result = DatabaseConnection::getResult("SELECT * FROM " . static::$table . " WHERE id=:id", [":id" => $id]);
        if (empty($result)) {
            return null;
        }

        $object = new static();
        foreach ($result[0] as $property => $value) {
            $object -> $property = $value;
        }

        return $object;
    }

    /**
     * Return all entities as an array
     *
     * @return array
     */
    public static function getAll() {
        $entities = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM " . static::$table);

        foreach($sqlResult as $row) {
            $object = new static();
            foreach($row as $property => $value) {
                $object -> $property = $value;
            }

            $entities[] = $object;
        }

        return $entities;
    }

    /**
     * Returns the current model as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }
}