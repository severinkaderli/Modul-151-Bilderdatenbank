<?php
namespace Core\Controller;

use Core\Utility\MessageHandler;
use Core\Routing\Redirect;
use Core\Model\User;
use Core\View\View;

/**
 * @author Severin Kaderli
 */
class SettingController
{
    /**
     * Show the settings page for the current user
     * 
     * @return void
     */
    public function showSettings()
    {
        $view = new View("users.settings");
        $view->render();
    }

    /**
     * Changes the password of the logged in user.
     * 
     * @return void
     */
    public function changePassword()
    {
        // Check if password confirmation matches
        if($_POST["password"] == $_POST["password_confirmation"]) {
            $user = User::find($_SESSION["user"]["id"]);
            $user->changePassword($_POST["oldPassword"], $_POST["password"]);
        }

        MessageHandler::add("The passwords don't match!", MessageHandler::STATUS_WARNING);
        Redirect::to("/settings");
    }

    /**
     * Deletes the current logged in user.
     * 
     * @return void
     */
    public function deleteUser()
    {
        User::delete($_SESSION["user"]["id"]);
        Redirect::to("/logout");
    }
}