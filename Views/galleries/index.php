<?php

use Core\Utility\MessageHandler;
use Core\Model\Image;

require_once(__ROOT__ . "Views/_header.php");

MessageHandler::display();

foreach ($this->galleries as $gallery) {
    $images = Image::getByGalleryId($gallery->id);
    echo "<div class='gallery'>";
    echo "<header class='gallery__header'>";
    echo "<h1><a href='gallery/" . $gallery->id . "'>".$gallery->name. "</a><small class='pull-right'>";
    if (isset($_SESSION["user"]["id"])) {
        if ($gallery->fk_user_id == $_SESSION["user"]["id"]) {
            echo " <a onclick='return confirm_delete()' href='gallery/".$gallery->id."/delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a> ";
            echo "<a href='gallery/".$gallery->id."/edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> ";
        }
    }
    echo "</small></h1>";
    echo "</header>";
    foreach($images as $image) {
        echo "<div><img style='float:left' src='" . $image->thumbnail_path . "'></div>";
    }
    echo "</div>";
}

require_once(__ROOT__ . "Views/_footer.php");