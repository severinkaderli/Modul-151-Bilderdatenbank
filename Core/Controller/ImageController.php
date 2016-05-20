<?php

namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Utility\MessageHandler;
use Core\Model\Gallery;
use Core\Model\Image;
use Core\View\View;

class ImageController
{
    /**
     * Delete the image with the given id.
     * 
     * @param  int $id - The id of the image.
     * @return void
     */
    public function destroy(int $id)
    {
        $image = Image::find($id);
        $gallery = Gallery::find($image->fk_gallery_id);
        if($_SESSION["user"]["id"] != $gallery->fk_user_id) {
            Redirect::to("/");
        }

        Image::delete($id);

        Redirect::to("/gallery/" . $gallery->id);
    }

    /**
     * Show the form to edit an image.
     * 
     * @param  int $id - The id of the image.
     * @return void
     */
    public function edit(int $id)
    {
        //$tags = Tag::getByImageId($id);
        $view = new View("images.edit");
        $view->render();
    }
    
}