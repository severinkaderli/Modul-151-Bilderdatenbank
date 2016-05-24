<?php

use Core\Model\User;
use Core\Model\Image;
use Core\Model\Tag;

require_once(__ROOT__ . "Views/_header.php");

$user = User::find($gallery->fk_user_id);
$images = Image::getByGalleryId($gallery->id);
?>
    <div class="col-md-12">
        <div class="gallery panel panel-primary">
            <header class="gallery__header panel-heading">
                <h3>
                <?php echo htmlspecialchars($gallery->name);
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
            	<?php echo "von " . htmlspecialchars($user->username);?>
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
                <h2>Upload</h2>
            	<div class="uploadForm">
	            	<form action="gallery/<?php echo $gallery->id;?>/upload" enctype="multipart/form-data" method="POST">
	            		<div class="form-group">
	            			<label for="imageUpload">Bilder hochladen (max. 10MB gesamt) </label>
	            			<input required multiple id="imageUpload" type="file" name="files[]">
	            		</div>
                        <div class="form-group">
                            <label for="tags">Bilder taggen (Mehrfachauswahl möglich) </label>
                            <br>
                            <select class="form-control" multiple name="tags[]" id="tags">
                                <?php
                                    foreach($this->tags as $tag){
                                        echo "<option value='" . $tag->id . "'>";
                                            echo htmlspecialchars($tag->tag);
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                        </div>
	            		<div class="form-group">
	            			<input class="btn btn-primary" type="submit" value="Hochladen">
	            		</div>
	            	</form>
            	</div>
                <hr>
            </div>
            <?php
            endif;
            ?>
            <div class="col-md-12">
            <h2>Bilder</h2>
            <form>
                <div class="form-group">
                    <label for="searchTags">Suche nach Tags (Mehrfachauswahl möglich)</label>
                    <select class="form-control" multiple name="searchTags[]" id="searchTags">
                        <?php
                            foreach($this->tags as $tag){
                                echo "<option value='" . $tag->id . "'>";
                                    echo htmlspecialchars($tag->tag);
                                echo "</option>";
                            }
                        ?>
                    </select>
                </div>
            </form>
            <?php
            foreach($images as $image):
                $imageTags = Tag::getByImageId($image->id);
                $tags = "";
                $dataTags = "";
                foreach ($imageTags as $tag) {
                    $dataTags .= $tag->id . ",";
                    $tags .= "<span class='label label-primary'>" . htmlspecialchars($tag->tag) ."</span> ";
                }
            ?>
                <div data-tags="<?php echo rtrim($dataTags, ",");?>" class="col-md-3 col-xs-6">
                    <div class="thumbnail">
                        <a target="_blank" href="<?php echo $image->image_path; ?>"><img src="<?php echo $image->thumbnail_path; ?>"></a>
                        <div class="caption">
				        <small>
                            Grösse: <?php echo $image->width . "x" .$image->height . "px";?>
                            <br>
					        Dateigrösse: <?php echo round($image->size / (1000 * 1000), 2); ?>MB
					        <br>
					        Dateityp: <?php echo $image->filetype; ?>
					        <br>
					        Tags: <?php echo $tags;?>
					        <?php
					        if($this->isOwn):
					        ?>
					        <br>
					        <br>
					        <a href="image/<?php echo $image->id;?>/edit">Bearbeiten</a>
					        <br>
					        <a onclick="confirm_delete('Do you really want to delete this image?');"href="image/<?php echo $image->id;?>/delete">Löschen</a>
					        <?php
					        endif;
					        ?>
					       	</small>
					    </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
            </div>
            </section>     
        </div>
    </div>
<?php

require_once(__ROOT__ . "Views/_footer.php");