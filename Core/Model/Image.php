<?php

namespace Core\Model;

use Core\Database\DatabaseConnection;

/**
* @author Severin Kaderli
*/
class Image extends Model
{

    /**
     * @var
     */
    static protected $table = "images";

    public function __construct()
    {
       parent::__construct();
    }


    /**
     * Return all posts as an array
     *
     * @return mixed
     */
    public static function getAll() {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM comments");

        foreach($sqlResult as $comment) {
            $commentObject = new Comment();
            $commentObject->id = $comment["id"];
            $commentObject->comment = $comment["comment"];
            $commentObject->fk_post_id = $comment["fk_post_id"];
            $commentObject->fk_user_id = $comment["fk_user_id"];

            $result[] = $commentObject;
        }

        return $result;
    }

    /**
     * Return all posts by user id as an array
     *
     * @return mixed
     */
    public static function getByUserId($userId) {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM comments WHERE fk_user_id=:user_id", ["user_id" => $userId]);

        foreach($sqlResult as $comment) {
            $commentObject = new Comment();
            $commentObject->id = $comment["id"];
            $commentObject->comment = $comment["comment"];
            $commentObject->fk_post_id = $comment["fk_post_id"];
            $commentObject->fk_user_id = $comment["fk_user_id"];

            $result[] = $commentObject;
        }

        return $result;
    }

    public static function create($postId, array $fields) {
        DatabaseConnection::insert("INSERT INTO comments(comment, fk_post_id, fk_user_id) VALUES(:comment, :post_id, :user_id)", ["comment" => htmlentities($fields["comment"]), "post_id" => $postId, "user_id" => $_SESSION["user"]["id"]]);
    }

    public static function delete($commentId) {
        DatabaseConnection::insert("DELETE FROM comments WHERE id=:comment_id", ["comment_id" => $commentId]);
    }

    /**
     * Return comments by post id
     *
     * @param int $postId
     * @return mixed
     */
    public static function getByPostId($postId) {
        $result = [];
        $sqlResult = DatabaseConnection::getResult("SELECT * FROM comments WHERE fk_post_id=:postId", ["postId" => $postId]);

        foreach($sqlResult as $comment) {
            $commentObject = new Comment();
            $commentObject->id = $comment["id"];
            $commentObject->comment = $comment["comment"];
            $commentObject->fk_post_id = $comment["fk_post_id"];
            $commentObject->fk_user_id = $comment["fk_user_id"];

            $result[] = $commentObject;
        }

        return $result;
    }

}