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
     * Delete the entry with the given id from the database.
     *
     * @param $id
     */
    public static function delete($id) {
        DatabaseConnection::insert("DELETE FROM " . static::$table . " WHERE id=:id", ["id" => $id]);
    }

    /**
     * @param $postId
     * @param array $fields
     */
    public static function create($id, array $fields) {
        DatabaseConnection::insert("INSERT INTO comments(comment, fk_post_id, fk_user_id) VALUES(:comment, :post_id, :user_id)", ["comment" => htmlentities($fields["comment"]), "post_id" => $postId, "user_id" => $_SESSION["user"]["id"]]);
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