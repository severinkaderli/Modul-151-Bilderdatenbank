<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;
use Core\Utility\MessageHandler;
use Core\Routing\Redirect;

/**
 * @author Severin Kaderli
 */
class User extends Model
{
    /**
     * @var string
     */
    static protected $table = "users";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks whether a user is logged in or not
     *
     * @return bool
     */
    public static function auth()
    {

        if (isset($_SESSION["user"]["logged_in"]) && $_SESSION["user"]["logged_in"] === true) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isAdmin() {
        if (isset($_SESSION["user"]["logged_in"]) && $_SESSION["user"]["is_admin"] == 1) {
            return true;
        }

        return false;
    }

    /**
     * Try to login with a user
     *
     * @return bool
     */
    public function login()
    {

        $checkUser = User::getByUsername($this->username);
        if (password_verify($this->password, $checkUser->password)) {

            $_SESSION["user"]["logged_in"] = true;
            $_SESSION["user"]["id"] = $checkUser->id;
            $_SESSION["user"]["username"] = $this->username;
            $_SESSION["user"]["is_admin"] = $checkUser->is_admin;

            Redirect::to("/");
        }

        // Password or username are not valid
        MessageHandler::add("Username or password is invalid!", MessageHandler::STATUS_WARNING);
        Redirect::to("/login");
    }

    /**
     * Save the user data in db
     */
    public function register()
    {
        // Check if the E-Mail is already taken
        if (User::exists($this->username)) {
            MessageHandler::add("This E-Mail is already taken! Please use another one!", MessageHandler::STATUS_WARNING);
            Redirect::to("/");
        }

        // Insert the new user in the database
        DatabaseConnection::insert("INSERT INTO users(username, password, is_admin) VALUES(:username, :password, 0)",
            ["username" => $this->username,
                "password" => password_hash($this->password, PASSWORD_BCRYPT)]);
    }

    /**
     * Deletes the user with the given id and all of his galleries.
     * 
     * @param  int $id
     * @return void
     */
    public static function delete(int $id)
    {
        parent::delete($id);
        $galleries = Gallery::getByUserId($id);
        foreach($galleries as $gallery) {
            Gallery::delete($gallery->id);
        }
    }

    /**
     * Updates the password of the user.
     * 
     * @param  int $id - The id of the user
     * @param  string $oldPassword
     * @param  string $newPassword
     * @return void
     */
    public function changePassword($oldPassword, $newPassword)
    {
        // Check if the old password is incorrect
        var_dump($oldPassword);
        var_dump($newPassword);
        var_dump($this->id);
        if(password_verify($oldPassword, $this->password)) {

            // Update the password in the database.
            DatabaseConnection::insert("UPDATE users SET password=:password WHERE id=:id", [
                ":password" => password_hash($newPassword, PASSWORD_BCRYPT),
                ":id" => $this->id
            ]);

            MessageHandler::add("Password was successfully updated!", MessageHandler::STATUS_SUCCESS);
            Redirect::to("/settings");
        }

        MessageHandler::add("Old password is incorrect!", MessageHandler::STATUS_WARNING);
        Redirect::to("/settings/password");
    }


    /**
     * Return an user by its username
     *
     * @param string $username
     * @return User
     */
    public static function getByUsername($username)
    {
        $result = DatabaseConnection::getResult("SELECT * FROM users WHERE username=:username", ["username" => $username]);

        $userObject = new User();
        $userObject->id = $result[0]["id"];
        $userObject->username = $result[0]["username"];
        $userObject->password = $result[0]["password"];
        $userObject->is_admin = $result[0]["is_admin"];

        return $userObject;
    }

    /**
     * Checks if an user already exists
     *
     * @param string $username
     * @return bool
     */
    public static function exists($username)
    {

        $result = DatabaseConnection::getResult("SELECT * FROM users WHERE username=:username", ["username" => $username]);

        if (!empty($result)) {
            return true;
        }

        return false;
    }

    public static function promote($userId) {
        DatabaseConnection::insert("UPDATE users  SET is_admin=1 WHERE id=:user_id", ["user_id" => $userId]);
    }


}