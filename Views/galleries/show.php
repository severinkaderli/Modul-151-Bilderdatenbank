<?php

use Core\Model\User;
use Core\Model\Image;

require_once(__ROOT__ . "Views/_header.php");

$user = User::find($gallery->fk_user_id);
$images = Image::getByGalleryId($gallery->id);
?>
    <div class="col-md-12">
        <div class="gallery panel panel-primary">
            <header class="gallery__header panel-heading">
                <h3>
                <?php echo $gallery->name;
                if($this->isOwn):
                ?>
                <small class="icon-links pull-right">
                    <?php
                    if (isset($_SESSION["user"]["id"])) {
                        if ($gallery->fk_user_id == $_SESSION["user"]["id"]) {
                            echo " <a onclick='return confirm_delete()' href='gallery/".$gallery->id."/delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a> ";
                            echo "<a href='gallery/".$gallery->id."/edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> ";
                        }
                    }
                    ?>   
                </small>
                <?php
                else:
                ?>
            	<small class="gallery__user">
            	<?php echo "von " . $user->username;?>
            	</small>
            	<?php
            	endif;
            	?>
                </h3>
            </header>
            <section class="gallery__content panel-body">
            <?php
            if($this->isOwn):
            ?>
            <div class="col-md-12">
            	<div class="uploadForm">
	            	<form action="gallery/<?php echo $gallery->id;?>/upload" enctype="multipart/form-data" method="POST">
	            		<div class="form-group">
	            			<label for="imageUpload">Bilder hochladen: </label>
	            			<input multiple id="imageUpload" type="file" value="Bilder hochladen" name="files[]">
	            		</div>
	            		<div class="form-group">
	            			<input type="submit" value="Hochladen">
	            		</div>
	            	</form>
            	</div>
            </div>
            <?php
            endif;
            foreach($images as $image): ?>
                <div class="col-md-3 col-xs-6">
                    <a href="image/<?php echo $image->id;?>" class="thumbnail">
                        <img src="<?php echo $image->image_path; ?>">
                    </a>
                </div>
            <?php
            endforeach;
            ?>
            </section>     
        </div>
    </div>
<?php

require_once(__ROOT__ . "Views/_footer.php");