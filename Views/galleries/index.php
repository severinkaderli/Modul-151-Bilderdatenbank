<?php
require_once(__ROOT__ . "Views/_header.php");

foreach ($this->galleries as $gallery) {
    $user = Core\Model\User::find($gallery->fk_user_id);
    echo "<div class='post'>";
    echo "<header class='post__header'>";
    echo "<h1><a href='post/" . $gallery->id . "'>".$gallery->title. "</a><br><small>" . date(DATE_FORMAT, $gallery->post_time) . " von ".$user->firstname." ".$user->lastname;
    if (isset($_SESSION["user"]["id"])) {
        if (gallery->fk_user_id == $_SESSION["user"]["id"]) {
            echo " <a onclick='return confirm_delete()' href='gallery/".$gallery->id."/delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a> ";
            echo "<a href='post/".$gallery->id."/edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> ";
        }
    }
    echo "</small></h1>";
    echo "</header>";

    echo "<div class='post__content'>";
    echo "<p>" . nl2br($gallery->content) . "</p>";
    echo "</div>";
    echo "</div>";
}

require_once(__ROOT__ . "Views/_footer.php");