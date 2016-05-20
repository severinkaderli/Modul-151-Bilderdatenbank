<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;

/**
* @author Severin Kaderli
*/
class Tag extends Model
{

    /**
     * @var string
     */
    static protected $table = "tags";

    public function __construct()
    {
       parent::__construct();
    }

    public static function getByImageId(int $imageId) {
        $entities = [];
        $sqlResult = DatabaseConnection::getResult("SELECT t.id, t.tag FROM tags as t LEFT JOIN images_tags as it ON t.id=it.fk_tag_id LEFT JOIN images as i ON i.id=it.fk_image_id WHERE i.id=:image_id", [":image_id" => $imageId]);

        foreach($sqlResult as $row) {
            $object = new static();
            foreach($row as $property => $value) {
                $object -> $property = $value;
            }

            $entities[] = $object;
        }

        return $entities;
    }
}