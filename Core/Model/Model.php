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
     * @return mixed
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
     * Returns the current model as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }
}