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
</script>
</body>
</html>