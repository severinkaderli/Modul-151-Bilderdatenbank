<?php require_once(__ROOT__ . "Views/_header.php");?>
    <h1>Galerie aktualisieren</h1>
    <form method="POST" action="gallery/<?php echo $this->gallery->id;?>">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $this->gallery->name; ?>" class="form-control">
        </div>
        <div class="form-group">
            <lable for="sharing">Teilen:</lable>
            <input type="checkbox" name="share" id="share" <?php echo $gallery->is_shared == 1 ? "checked" : "";?>>
        </div>
        <div class="form-group">
            <input type="submit" name="createPostSubmit" value="Galerie aktualisieren" class="btn btn-default">
        </div>
    </form>
<?php require_once(__ROOT__ . "Views/_footer.php"); ?>