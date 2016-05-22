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
     * Delete the image and all images_tags rows from this image.
     * 
     * @param  int $id - The id of the image
     * @return void
     */
    public static function delete(int $id)
    {
        parent::delete($id);
        DatabaseConnection::insert("DELETE FROM images_tags WHERE fk_image_id=:image_id", [
            ":image_id" => $id
        ]);
    }

    /**
     * Create a new image.
     * 
     * @param array $fields
     * @return void
     */
    public static function create(array $fields) {
        DatabaseConnection::insert("INSERT INTO images(image_path, thumbnail_path, size, filetype, width, height,fk_gallery_id) VALUES(:image_path, :thumbnail_path, :size, :filetype, :width, :height, :gallery_id)", [
            "image_path" => $fields["image_path"],
            "thumbnail_path" => $fields["thumbnail_path"],
            "size" => $fields["size"],
            "filetype" => $fields["filetype"],
            "width" => $fields["width"],
            "height" => $fields["height"],
            "gallery_id" => $fields["gallery_id"]
            ]);
    }

    /**
     * Update tags of an image
     *
     * @param int $id - The id of the image
     * @param array $fields
     * @return void
     */
    public static function update(int $id, array $fields)
    {
        DatabaseConnection::insert("DELETE FROM images_tags WHERE fk_image_id=:image_id", [
            ":image_id" => $id
        ]);

        foreach($fields["tags"] as $tagId) {
            DatabaseConnection::insert("INSERT INTO images_tags (fk_image_id, fk_tag_id) VALUES (:image_id, :tag_id)", [
                ":image_id" => $id,
                ":tag_id" => $tagId
            ]);
        }
    }

    /**
     * Return all images of a gallery.
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