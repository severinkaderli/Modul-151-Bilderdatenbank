<?php
require_once(__ROOT__ . "Views/_header.php");
?>

<a href="">Go back to gallery overview</a>
<div class="image-tags">
	<span class="label label-primary">Tag-1</span>
</div>
<a title='Open picture in new tab' href='<?php echo BASE_DIR . "/" . $this->image->image_path;?>' target='_blank'><img class="single-image" src="<?php echo $this->image->image_path;?>" /><a>

<?php
require_once(__ROOT__ . "Views/_footer.php");