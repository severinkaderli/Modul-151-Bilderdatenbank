<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;

/**
* @author Severin Kaderli
*/
class Image extends Model
{

    /**
     * @var string
     */
    static protected $table = "images";

    public function __construct()
    {
       parent::__construct();
    }

    /**
     * @param  array  $fields
     * @return void
     */
    public static function create(array $fields) {
        DatabaseConnection::insert("INSERT INTO images(image_path, thumbnail_path, fk_gallery_id) VALUES(:image_path, :thumbnail_path, :gallery_id)", ["image_path" => $fields["image_path"], "thumbnail_path" => $fields["thumbnail_path"], "gallery_id" => $fields["gallery_id"]]);
    }

    /**
     * Return comments by post id
     *
     * @param int $galleryId
     * @return array
     */
    public static function getByGalleryId(int $galleryId) : array
    {
        $images = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM images WHERE fk_gallery_id=:galleryId", ["galleryId" => $galleryId]);

        foreach($sqlResult as $row) {
            $image = new Image();

            foreach($row as $property => $value) {
                $image -> $property = $value;
            }

            $images[] = $image;
        }

        return $images;
    }

}