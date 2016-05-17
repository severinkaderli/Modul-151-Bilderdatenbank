<?php

namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Utility\MessageHandler;
use Core\Model\Gallery;
use Core\Model\Image;
use Core\Model\User;
use Core\View\View;

class GalleryController
{
    /**
     * Renders a listing of all blog posts. Only posts of the current page
     * are shown.
     *
     */
    public function index()
    {
        // If user is not logged in redirect him to the login page
        if (!User::auth()) {
            Redirect::to("/login");
        }

        $view = new View("galleries.index");
        $view->assign("galleries", Gallery::getByUserId($_SESSION["user"]["id"]));
        $view->render();
    }

    /**
     * Show a single post by postId.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        /**
         * Check if the postId is valid and if a post with that id
         * exists. If no post can be found the user will be redirected to the
         * index page.
         */
        if (!is_numeric($id)) {
            Redirect::to("/");
        }
        $gallery = Gallery::find($id);
        if (is_null($gallery)) {
            Redirect::to("/");
        }

        /**
         * Assign variables to view and render it
         */
        $view = new View("galleries.show");
        $view->assign("gallery", $gallery);
        //$view->assign("images", Image::getByGalleryId($gallery->id));
        $view->render();
    }

    public function create()
    {
        $view = new View("galleries.create");
        $view->render();
    }

    public function store()
    {
        Gallery::create($_POST);
        Redirect::to("/");
    }

    public function edit($id)
    {
        //Check if user is allowed to delete the post
        $gallery = Gallery::find($id);
        if ($_SESSION["user"]["id"] != $gallery->fk_user_id) {
            Redirect::to("/");
        }

        $view = new View("galleries.edit");
        $view->assign("gallery", $gallery);
        $view->render();
    }

    public function update($id)
    {
        //Check if user is allowed to delete the post
        $gallery = Gallery::find($id);
        if ($_SESSION["user"]["id"] != $gallery->fk_user_id) {
            Redirect::to("/");
        }
        Gallery::update($id, $_POST);
        Redirect::to("/");
    }

    public function delete($id)
    {
        $gallery = Gallery::find($id);

        if ($gallery->fk_user_id != $_SESSION["user"]["id"]) {
            Redirect::to("/");
        }
        Gallery::delete($id);
        Redirect::to("/");
    }

    /**
     * Uploads one or multiple image to the given gallery.
     * 
     */
    public function upload($id)
    {
        if (DEBUG) {
            echo "<pre>";
            var_dump($_FILES);
            echo "</pre>";
        }

        for ($i = 0, $length = count($_FILES["files"]["name"]); $i < $length; $i++) {

            // Check if there were any errors during the upload.
            if ($_FILES["files"]["error"][$i] !== UPLOAD_ERR_OK) {
                MessageHandler::add("An error occurred during upload. Please try again!", MessageHandler::STATUS_DANGER);
                Redirect::to("/");
            }

            // Check if the file is an image using the getimagesize() function.
            $imageInfo = getimagesize($_FILES["files"]['tmp_name'][$i]);
            if ($imageInfo === false) {
                //ERROR: NOT IMAGE
                MessageHandler::add("Please upload an image (.png, .jpg, .gif)!", MessageHandler::STATUS_DANGER);
                Redirect::to("/");
            }

            // Check if image is one of the supported formats.
            if (($imageInfo[2] !== IMAGETYPE_GIF) && ($imageInfo[2] !== IMAGETYPE_JPEG) && ($imageInfo[2] !== IMAGETYPE_PNG)) {
                MessageHandler::add("Please upload a supported image (.png, .jpg, .gif)!", MessageHandler::STATUS_DANGER);
                Redirect::to("/");
            }

            // Create a unique file name for the image
            $fileParts = explode(".", $_FILES["files"]["name"][$i]);
            $fileName = strtolower(uniqid() . "." . end($fileParts));
            $dbFullPath = "upload/images/" . "full_" . $fileName;
            $dbThumbPath = "upload/images/" . "thumb_" . $fileName;
            $fullPath = __ROOT__ . $dbFullPath;
            $thumbPath = __ROOT__ . $dbThumbPath;

            // Move the uploaded file to the /upload/images folder
            if (!move_uploaded_file($_FILES["files"]["tmp_name"][$i], $fullPath)) {
                MessageHandler::add("An error occurred during upload. Please try again!", MessageHandler::STATUS_DANGER);
                Redirect::to("/");
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
                    $imageSaveFunction = "ImageGIF";
                    $imageCreateFunction = "ImageCreateFromGIF";
                    break;

                case IMAGETYPE_JPEG:
                    $imageSaveFunction = "ImageJPEG";
                    $imageCreateFunction = "ImageCreateFromJPEG";
                    break;

                case IMAGETYPE_PNG:
                    $imageSaveFunction = "ImagePNG";
                    $imageCreateFunction = "ImageCreateFromPNG";
                    break;
            }

            $fullImage = $imageCreateFunction($fullPath);
            $thumbImage = imagecreatetruecolor($imageWidth, $imageHeight);
            imagecopyresized($thumbImage, $fullImage, 0, 0, 0, 0, $imageWidth, $imageHeight, $width, $height);
            $imageSaveFunction($thumbImage, $thumbPath);

            // Add image to the database
            Image::create([
                "image_path" =>$dbFullPath,
                "thumbnail_path" => $dbThumbPath,
                "gallery_id" => $id
            ]);
            
        }

        Redirect::to("/gallery/" . $id);
    }
}