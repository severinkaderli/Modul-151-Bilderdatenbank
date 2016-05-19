<?php
namespace Core\Controller;

use Core\Routing\Redirect;
use Core\Model\Post;
use Core\Model\User;
use Core\Model\Comment;
use Core\View\View;

class UserController
{
    /**
     * Display a list of the users.
     * 
     * @return void
     */
    public function index()
    {
        if(!User::isAdmin()) {
            Redirect::to("/");
        }

        $users = User::getAll();
        $view = new View("users.index");
        $view->assign("users", $users);
        $view->render();
    }

    /**
     * Deletes the user with the given id.
     * 
     * @param  int $id - The id of the user.
     * @return void
     */
    public function destroy($id)
    {
        if(!User::isAdmin()) {
            Redirect::to("/");
        }

        // Make sure you don't delete your own account
        if($_SESSION["user"]["id"] == $id) {
            Redirect::to("/");
        }

        User::delete($id);

        Redirect::to("/users");
    }

    /**
     * Promote the user to an admin.
     * 
     * @param  int $id - The id of the user.
     * @return void
     */
    public function promote($id)
    {
        if(!User::isAdmin()) {
            Redirect::to("/");
        }

        User::promote($id);
        Redirect::to("/users");
    }
}