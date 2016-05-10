<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;
use Core\Routing\Redirect;

/**
 * @author Severin Kaderli
 */
class User extends Model
{

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

        Redirect::to("/login");
    }

    /**
     * Save the user data in db
     */
    public function register()
    {

        if (User::exists($this->username)) {
            Redirect::to("/");
        }

        DatabaseConnection::insert("INSERT INTO users(username, password, is_admin) VALUES(:username, :password, 0)",
            ["username" => $this->username,
                "password" => password_hash($this->password, PASSWORD_BCRYPT)]);
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