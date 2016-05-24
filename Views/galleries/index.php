<?php
use Core\Model\Image;
use Core\Model\User;

require_once(__ROOT__ . "Views/_header.php");
?>

<div class="col-md-12">
<h1>Your galleries</h1>
<?php
foreach ($this->galleries as $gallery):
    $user = User::find($gallery->fk_user_id);
    $images = Image::getByGalleryId($gallery->id);
?>
    <div class="col-md-6">
        <div class="gallery panel panel-primary">
            <header class="gallery__header panel-heading">
                <h3>
                <?php echo htmlspecialchars($gallery->name);?>
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
                </h3>
            </header>
            <section class="gallery__content panel-body">
            <?php
            $i = 1;
            foreach($images as $image): ?>
                <div class="col-md-4 col-xs-6">
                    <a href="image/<?php echo $image->id;?>" class="thumbnail">
                        <img src="<?php echo $image->thumbnail_path; ?>">
                    </a>
                </div>
            <?php
            if($i >= 6) {
                break;
            }
            $i++;
            endforeach;
            ?>
            <div class="gallery__button clearfix col-md-12">
            <a class="btn btn-primary" href="gallery/<?php echo $gallery->id;?>">Show full gallery</a>
            </div>
            </section>     
        </div>
    </div>

<?php endforeach; ?>
</div>

<div class="col-md-12">
<h1>Shared galleries from other people</h1>
<?php
foreach ($this->sharedGalleries as $sharedGallery):
    $user = User::find($sharedGallery->fk_user_id);
    $images = Image::getByGalleryId($sharedGallery->id);
?>
    <div class="col-md-6">
        <div class="gallery  panel panel-primary">
            <header class="gallery__header panel-heading">
                <h3>
                <?php echo htmlspecialchars($sharedGallery->name);?>
                <small class="gallery__user pull-right">
                von <?php echo htmlspecialchars($user->username);?>
                </small>
                </h3>
            </header>
            <section class="gallery__content panel-body">
            <?php
            $i = 1;
            foreach($images as $image): ?>
                <div class="col-md-4 col-xs-6">
                    <a href="image/<?php echo $image->id;?>" class="thumbnail">
                        <img src="<?php echo $image->thumbnail_path; ?>">
                    </a>
                </div>
            <?php
            if($i >= 6) {
                break;
            }
            $i++;
            endforeach;
            ?>
            <div class="gallery__button clearfix col-md-12">
            <a class="btn btn-primary" href="gallery/<?php echo $sharedGallery->id;?>">Show full gallery</a>
            </div>
            </section>     
        </div>
    </div>

<?php endforeach;?>
</div>

<?php
require_once(__ROOT__ . "Views/_footer.php");