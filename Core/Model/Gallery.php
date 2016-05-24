<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;
use Core\Model\Image;
use Core\Model\User;

/**
 * Gallery Model
 *
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 * @package Core\Model
 */
class Gallery extends Model
{

    /**
     * @var string
     */
    static protected $table = "galleries";

    /**
     * Gallery constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Deletes the gallery with the given id and all of its images.
     * 
     * @param  int $id - The id of the gallery.
     * @return void
     */
    public static function delete(int $id)
    {
        parent::delete($id);

        // Delete all images that belong to this gallery.
        // Delete all the images of this gallery
        $images = Image::getByGalleryId($id);
        foreach($images as $image) {
            Image::delete($id);
        }
    }

    /**
     * Return all posts by user id
     *
     * @param int $userId
     * @return array
     */
    public static function getByUserId(int $userId) : array
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
     * Get all galleries that are shared.
     * 
     * @return array
     */
    public static function getShared() : array
    {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM galleries WHERE is_shared=1 AND fk_user_id <> :current_user_id", ["current_user_id" => $_SESSION["user"]["id"]]);

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
     * Set is_shared to true.
     * 
     * @param  int $galleryId - The id of the gallery.
     * @return void
     */
    public static function share(int $galleryId)
    {
        DatabaseConnection::insert("UPDATE galleries SET is_shared=:is_shared WHERE id=:gallery_id",[
            "is_shared" => 1,
            "gallery_id" => $galleryId
        ]);
    }

    /**
     * Set is_shared to false.
     * 
     * @param  int $galleryId - The id of the gallery.
     * @return void
     */
    public static function unShare(int $galleryId)
    {
        DatabaseConnection::insert("UPDATE galleries SET is_shared=:is_shared WHERE id=:gallery_id",[
            "is_shared" => 0,
            "gallery_id" => $galleryId
        ]);
    }

    /**
     * @param array $fields
     */
    public static function create(array $fields)
    {
        DatabaseConnection::insert("INSERT INTO galleries(name, is_shared, fk_user_id)
              VALUES(:name, :is_shared, :user_id)",
            [":name" => htmlentities($fields["name"]),
                ":is_shared" => $fields["share"] == "on" ? 1 : 0,
                ":user_id" => $_SESSION["user"]["id"]]);
    }

    /**
     * @param int $galleryId
     * @param array $fields
     */
    public static function update($galleryId, array $fields)
    {
        DatabaseConnection::insert("UPDATE galleries SET name=:name, is_shared=:is_shared WHERE id=:gallery_id",
            [":name" => htmlentities($fields["name"]),
                ":is_shared" => $fields["share"] == "on" ? 1 : 0,
                ":gallery_id" => $galleryId]);
    }


}