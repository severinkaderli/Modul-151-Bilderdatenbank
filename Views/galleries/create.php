<?php require_once(__ROOT__ . "Views/_header.php"); ?>
    <h1>Galerie erstellen</h1>
    <form method="POST" action="gallery">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <lable for="sharing">Teilen:</lable>
            <input type="checkbox" name="share" id="share">
        </div>
        <div class="form-group">
            <input type="submit" name="createGallerySubmit" value="Galerie erstellen" class="btn btn-default">
        </div>
    </form>
<?php require_once(__ROOT__ . "Views/_footer.php"); ?>