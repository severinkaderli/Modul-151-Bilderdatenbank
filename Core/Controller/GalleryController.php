<?php

namespace Core\Controller;

use Core\Database\DatabaseConnection;
use Core\Routing\Redirect;
use Core\Utility\MessageHandler;
use Core\Model\Gallery;
use Core\Model\Image;
use Core\Model\User;
use Core\Model\Tag;
use Core\View\View;

class GalleryController
{
    /**
     * Display the list of all galleries of the user and the ones that
     * are shared.
     * 
     * @return void
     */
    public function index()
    {
        if (!User::auth()) {
            Redirect::to("/login");
        }

        $galleries = Gallery::getByUserId($_SESSION["user"]["id"]);
        $sharedGalleries = Gallery::getShared();
        $view = new View("galleries.index");
        $view->assign("galleries", $galleries);
        $view->assign("sharedGalleries", $sharedGalleries);
        $view->render();
    }

    /**
     * Display a single gallery with all images.
     * 
     * @param  int $id - The id of the gallery
     * @return void
     */
    public function show(int $id)
    {
        if (!User::auth()) {
            Redirect::to("/login");
        }

        $gallery = Gallery::find($id);
        $isOwn = $_SESSION["user"]["id"] == $gallery->fk_user_id;
        
        // Redirect when gallery is not shared and not the users.
        if(!$isOwn && $gallery->is_shared=0) {
            Redirect::to("/");
        }

        $view = new View("galleries.show");
        $view->assign("gallery", $gallery);
        $view->assign("isOwn", $isOwn);
        $view->assign("tags", Tag::getAll());
        $view->render();
    }

    /**
     * Displays the form for creating a new gallery.
     * 
     * @return void
     */
    public function create()
    {
        $view = new View("galleries.create");
        $view->render();
    }

    /**
     * Stores a new gallery in the database.
     * 
     * @return void
     */
    public function store()
    {
        Gallery::create($_POST);
        Redirect::to("/");
    }

    /**
     * Display the form to edit a gallery.
     * 
     * @param  int $id - The id of the gallery.
     * @return void
     */
    public function edit(int $id)
    {
        $gallery = Gallery::find($id);
        if ($_SESSION["user"]["id"] != $gallery->fk_user_id) {
            Redirect::to("/");
        }

        $view = new View("galleries.edit");
        $view->assign("gallery", $gallery);
        $view->render();
    }

    /**
     * Update a gallery.
     * 
     * @param  int $id - The id of the gallery.
     * @return void
     */
    public function update(int $id)
    {
        $gallery = Gallery::find($id);
        if ($_SESSION["user"]["id"] != $gallery->fk_user_id) {
            Redirect::to("/");
        }
        Gallery::update($id, $_POST);
        Redirect::to("/");
    }

    /**
     * Delete a gallery.
     * 
     * @param  int $id - The id of the gallery.
     * @return void
     */
    public function destroy(int $id)
    {
        $gallery = Gallery::find($id);
        if ($gallery->fk_user_id != $_SESSION["user"]["id"]) {
            Redirect::to("/");
        }

        Gallery::delete($id);
        Redirect::to("/");
    }

    /**
     * Upload one or more images to the given gallery.
     * 
     * @param  int $id - The id of the gallery.
     * @return void
     */
    public function upload(int $id)
    {
        // Loop through each uploaded file
        for ($i = 0, $length = count($_FILES["files"]["name"]); $i < $length; $i++) {

            // Check if there were any errors during the upload.
            if ($_FILES["files"]["error"][$i] !== UPLOAD_ERR_OK) {
                MessageHandler::add("An error occurred during upload. Please try again!", MessageHandler::STATUS_DANGER);
                Redirect::to("/gallery/" . $id);
            }

            // Check if the file is an image using the getimagesize() function.
            $imageInfo = getimagesize($_FILES["files"]['tmp_name'][$i]);
            if ($imageInfo === false) {
                MessageHandler::add("Please upload an image (.png, .jpg, .gif)!", MessageHandler::STATUS_DANGER);
                Redirect::to("/gallery/" . $id);
            }

            // Check if image is one of the supported formats.
            if (($imageInfo[2] !== IMAGETYPE_GIF) && ($imageInfo[2] !== IMAGETYPE_JPEG) && ($imageInfo[2] !== IMAGETYPE_PNG)) {
                MessageHandler::add("Please upload a supported image (.png, .jpg or .gif)!", MessageHandler::STATUS_DANGER);
                Redirect::to("/gallery/" . $id);
            }

            // Create unique filename and get image size and paths.
            $fileSize = $_FILES["files"]["size"][$i];
            $fileParts = explode(".", $_FILES["files"]["name"][$i]);
            $fileName = strtolower(uniqid() . "." . end($fileParts));
            $dbFullPath = "upload/images/" . "full_" . $fileName;
            $dbThumbPath = "upload/images/" . "thumb_" . $fileName;
            $fullPath = __ROOT__ . $dbFullPath;
            $thumbPath = __ROOT__ . $dbThumbPath;

            // Move the uploaded file to the /upload/images folder
            if (!move_uploaded_file($_FILES["files"]["tmp_name"][$i], $fullPath)) {
                MessageHandler::add("An error occurred during upload. Please try again!", MessageHandler::STATUS_DANGER);
                Redirect::to("/gallery/" . $id);
            }

            // Create a thumbnail (100x100) from the uploaded image
            $thumbnailWidth = 100;
            $thumbnailHeight = 100;

            // Get original dimensions of the image
            $width = $imageInfo[0];
            $height = $imageInfo[1];

            // Keep the aspect ratio of the image when resizing it to a thumbnail
            if ( $width > $height) {
                $imageWidth = $thumbnailWidth;
                $imageHeight = intval($height * $imageWidth / $width);
            } else {
                $imageHeight = $thumbnailHeight;
                $imageWidth = intval($width * $imageHeight / $height);
            }

            // Get the correct PHP function for creating the image
            switch($imageInfo[2]) {
                case IMAGETYPE_GIF:
                    $fileType = ".gif";
                    $imageSaveFunction = "ImageGIF";
                    $imageCreateFunction = "ImageCreateFromGIF";
                    break;

                case IMAGETYPE_JPEG:
                    $fileType = ".jpg";
                    $imageSaveFunction = "ImageJPEG";
                    $imageCreateFunction = "ImageCreateFromJPEG";
                    break;

                case IMAGETYPE_PNG:
                    $fileType = ".png";
                    $imageSaveFunction = "ImagePNG";
                    $imageCreateFunction = "ImageCreateFromPNG";
                    break;
            }

            // "Resize" the image and save it
            $fullImage = $imageCreateFunction($fullPath);
            $thumbImage = imagecreatetruecolor($imageWidth, $imageHeight);
            imagecopyresized($thumbImage, $fullImage, 0, 0, 0, 0, $imageWidth, $imageHeight, $width, $height);
            $imageSaveFunction($thumbImage, $thumbPath);

            // Add image to the database
            Image::create([
                "image_path" =>$dbFullPath,
                "thumbnail_path" => $dbThumbPath,
                "size" => $fileSize,
                "filetype" => $fileType,
                "width" => $width,
                "height" => $height,
                "gallery_id" => $id
            ]);

            // Get id of the new image
            $imageId = DatabaseConnection::lastInsertId();

            // Save tags with the image
            foreach($_POST["tags"] as $tagId) {
                $tag = Tag::find($tagId);
                DatabaseConnection::insert("INSERT INTO images_tags(fk_image_id, fk_tag_id) VALUES(:image_id, :tag_id)", [
                    ":image_id" => $imageId,
                    ":tag_id" => $tag->id
                ]);
            }
            
        }

        Redirect::to("/gallery/" . $id);
    }
}