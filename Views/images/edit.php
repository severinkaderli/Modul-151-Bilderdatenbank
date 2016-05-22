<?php
require_once(__ROOT__ . "Views/_header.php");
?>

<img src="<?php echo $image->thumbnail_path;?>">
<form id="updateImageForm" action="image/<?php echo $image->id; ?>" method="POST">
    <div class="form-group">
        <label for="tags">Bilder taggen (Mehrfachauswahl möglich) </label>
        <br>
        <select class="form-control" multiple name="tags[]" id="tags">
            <?php
                foreach($this->tags as $tag){
                	$selected = "";
                	if(in_array($tag->id, $this->selectedTags)) {
                		$selected = "selected ";
                	}
                    echo "<option " . $selected . " value='" . $tag->id . "'>";
                        echo $tag->tag;
                    echo "</option>";
                }
            ?>
        </select>
    </div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Aktualisieren">
	</div>
</form>


<?php
require_once(__ROOT__ . "Views/_footer.php");