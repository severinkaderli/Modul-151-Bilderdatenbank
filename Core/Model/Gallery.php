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
     * Return all posts as an array
     *
     * @return mixed
     */
    public static function getAll()
    {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM galleries ORDER BY id DESC");

        foreach ($sqlResult as $gallery) {
            $postObject = new Gallery();
            $postObject->id = $gallery["id"];
            $postObject->name = $gallery["name"];
            $postObject->is_shared = $gallery["is_shared"];
            $postObject->fk_user_id = $gallery["fk_user_id"];

            $result[] = $postObject;
        }

        return $result;
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
            $postObject = new Gallery();
            $postObject->id = $gallery["id"];
            $postObject->name = $gallery["name"];
            $postObject->is_shared = $gallery["is_shared"];
            $postObject->fk_user_id = $gallery["fk_user_id"];

            $result[] = $postObject;
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

    /**
     * @param int $galleryId
     */
    public static function delete($galleryId) {
        DatabaseConnection::insert("DELETE FROM galleries WHERE id=:gallery_id", ["gallery_id" => $galleryId]);
    }


}