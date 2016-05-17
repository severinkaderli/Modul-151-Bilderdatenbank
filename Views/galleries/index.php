<?php
use Core\Model\Image;

require_once(__ROOT__ . "Views/_header.php");

foreach ($this->galleries as $gallery) {
    $images = Image::getByGalleryId($gallery->id);
    echo "<div class='gallery'>";
    echo "<header class='gallery__header'>";
    echo "<h1>".$gallery->name. "<small class='pull-right'>";
    if (isset($_SESSION["user"]["id"])) {
        if ($gallery->fk_user_id == $_SESSION["user"]["id"]) {
            echo " <a onclick='return confirm_delete()' href='gallery/".$gallery->id."/delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a> ";
            echo "<a href='gallery/".$gallery->id."/edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> ";
        }
    }
    echo "</small></h1>";
    echo "</header>";
    // Upload form
    echo "<div class='uploadForm'>";
    echo "<form action='gallery/" . $gallery->id . "/upload' enctype='multipart/form-data' method='POST'>";
    echo "<label for='imageUpload'>Bild(er) auswählen</label><input multiple id='imageUpload' type='file' value='Bild hochladen' name='files[]' >";
    echo "<input type='submit' value='Hochladen'>";
    echo "</form>";
    echo "</div>";

    foreach($images as $image) {
        echo "<a href='image/" . $image->id . "'><img class='gallery-image' src='" . $image->thumbnail_path . "'></a>";
    }
    echo "<div class='clearfix'></div>";
    echo "</div>";
}

require_once(__ROOT__ . "Views/_footer.php");