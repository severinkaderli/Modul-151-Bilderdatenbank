<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;

/**
 * Gallery Model
 *
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 * @package Core\Model
 */
class Gallery extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $is_shared;

    /**
     * @var int
     */
    public $fk_user_id;

    /**
     * Gallery constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all posts by user id
     *
     * @param int $userId
     * @return mixed
     */
    public static function getByUserId($userId)
    {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM galleries WHERE fk_user_id=:user_id", ["user_id" => $userId]);

        foreach ($sqlResult as $gallery) {
            $object = new Gallery();
            foreach($gallery as $attribute => $value) {
                $object -> $attribute = $value;
            }

            $result[] = $object;
        }

        return $result;
    }

    /**
     * @param array $fields
     */
    public static function create(array $fields)
    {
        DatabaseConnection::insert("INSERT INTO galleries(name, is_shared, fk_user_id)
              VALUES(:name, :is_shared, :user_id)",
            ["name" => htmlentities($fields["name"]),
                "is_shared" => htmlentities($fields["is_shared"]),
                "user_id" => $_SESSION["user"]["id"]]);
    }

    /**
     * @param int $galleryId
     * @param array $fields
     */
    public static function update($galleryId, array $fields)
    {
        DatabaseConnection::insert("UPDATE galleries SET name=:name, is_shared=:is_shared WHERE id=:gallery_id",
            ["name" => htmlentities($fields["name"]),
                "is_shared" => htmlentities($fields["is_shared"]),
                "gallery_id" => $galleryId]);
    }


}