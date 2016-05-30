<?php

namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Utility\MessageHandler;
use Core\Model\Gallery;
use Core\Model\Image;
use Core\Model\Tag;
use Core\View\View;

class ImageController
{
    /**
     * Delete the image with the given id.
     * 
     * @param  int $id - The id of the image.
     * @return void
     */
    public function destroy($id)
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
    public function edit($id)
    {
        $tags = Tag::getAll();
        $imageTags = Tag::getByImageId($id);
        $selectedTags = [];
        foreach($imageTags as $imageTag) {
            $selectedTags[] = $imageTag->id;
        }
        $view = new View("images.edit");
        $view -> assign("tags", $tags);
        $view->assign("selectedTags", $selectedTags);
        $view -> assign("image", Image::find($id));
        $view->render();
    }

    /**
     * Update the image with the given id.
     * 
     * @param  int $id - The id of the image.
     * @return void
     */
    public function update($id)
    {
        $image = Image::find($id);
        Image::update($id, $_POST);
        Redirect::to("/gallery/" . $image->fk_gallery_id);
    }


    
}