<?php

namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Utility\MessageHandler;
use Core\Model\Gallery;
use Core\Model\Image;
use Core\Model\User;
use Core\View\View;

class ImageController
{

    public function checkPermissions() {

    }

    /**
     * Renders a listing of all blog posts. Only posts of the current page
     * are shown.
     *
     */
    public function show($id)
    {
        // If user is not logged in redirect him to the login page
        if (!User::auth()) {
            Redirect::to("/login");
        }

        // Check if user has access to this image

        $view = new View("images.show");
        $image = Image::find($id);
        $view->assign("image", $image);
        $view->assign("gallery", Gallery::find($image->fk_gallery_id));
        $view->render();
    }
}