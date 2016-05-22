<footer id="footer">
    &copy;2016 - <?php echo SITE_AUTHOR; ?> - <a href="https://github.com/severinkaderli">GitHub</a>
</footer>
</div>
<script>
    function confirm_delete(message) {
    	if(!message) {
    		message = "Do you really want to delete?";
    	}
        return confirm(message);
    }

    // Fixing sizes of thumnails
    function refreshThumbnails() {
    	var maxHeight = 0;
    	$(".thumbnail").each(function() {
    		if($(this).height() > maxHeight) {
    			maxHeight = $(this).height();
    		}
    	});

    	$(".thumbnail").height(maxHeight);
    }

    $(window).load(function() {
    	refreshThumbnails();
    });

    $(window).resize(function() {
    	refreshThumbnails();
    });

    // Search for tags
    $("#searchTags").on("input", function() {
        // Hide all images
        $(".thumbnail").parent().hide();

        if($(this).val() == null) {
            // If no search tags are selected then show everything
            $(".thumbnail").parent().show();
        } else {
            // Only show images that have tags that are selected
            var searchTags = $(this).val();
            $(".thumbnail").parent().each(function() {
                
                // Get tags from the image
                var imageTags = $(this).data("tags");
                imageTags = String(imageTags).split(",");
                
                // Returns true if image has a tag that is selected
                var hasTag = imageTags.some(function (v) {
                    return searchTags.indexOf(v) >= 0;
                });

                if(hasTag) {
                    $(this).show();
                }
            });
        }
    });
</script>
</body>
</html>