<?php

namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Model\Gallery;
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
        $post = Gallery::find($id);
        if (is_null($post)) {
            Redirect::to("/");
        }

        /**
         * Assign variables to view and render it
         */
        $view = new View("posts.show");
        $view->assign("gallery", $gallery);
        $view->assign("images", Image::getByGalleryId($gallery->id));
        $view->render();
    }

    public function create() {
        $view = new View("galleries.create");
        $view->render();
    }

    public function store() {
        Gallery::create($_POST);
        Redirect::to("/");
    }

    public function edit($id) {
        //Check if user is allowed to delete the post
        $post = Gallery::find($id);
        if($_SESSION["user"]["id"] != $post->fk_user_id) {
            Redirect::to("/");
        }

        $view = new View("posts.edit");
        $view->assign("post", $post);
        $view->render();
    }

    public function update($id) {
        //Check if user is allowed to delete the post
        $post = Gallery::find($id);
        if($_SESSION["user"]["id"] != $post->fk_user_id) {
            Redirect::to("/");
        }
        Gallery::update($id, $_POST);
        Redirect::to("/");
    }

    public function delete($id){
        $gallery = Gallery::find($id);

        if($gallery->fk_user_id != $_SESSION["user"]["id"]) {
            Redirect::to("/");
        }
        Gallery::delete($id);
        Redirect::to("/");
    }
}