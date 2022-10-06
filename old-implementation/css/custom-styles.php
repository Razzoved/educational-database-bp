<style type="text/css">
	.material-thumb.dashicons:before, 
	.taxonomy-wrap a  {
		color: <?php echo get_option('ll_primary_color','#01579b'); ?>!important;
	}

	.links-wrap .material-link,
	.popup-close:hover,
	.comments-section input[type="submit"],
	.fm-button, 
	input[type="submit"].fm-button  {
		background-color: <?php echo get_option('ll_primary_color','#01579b');?> !important;
	}

	.material-thumb, .material-thumb.dashicons,
	.comments-section input[type="submit"]:hover,
	.fm-button:hover,
	input[type="submit"].fm-button:hover,
	.material-file-item:hover  {
		background-color: <?php echo get_option('ll_secondary_color','#4f83cc'); ?> !important;
	}

	.links-wrap .material-link:hover {
		background: <?php echo get_option('ll_secondary_color','#4f83cc');?> !important;
	}

	.download-icon svg path {
		fill: <?php echo get_option('ll_primary_color','#01579b'); ?> !important;
	}

	.single-material .fm-button:hover > .download-icon svg path {
		fill: <?php echo get_option('ll_secondary_color','#4f83cc');?> !important;
	}

	.fm-page-nav .page-numbers {
		background-color: <?php echo get_option('ll_secondary_color','#4f83cc'); ?> !important;
	}

	.fm-page-nav .page-numbers:hover,
	.fm-page-nav .page-numbers.current {
		background-color: <?php echo get_option('ll_primary_color','#01579b'); ?> !important;
	}

	.star.active svg path, 
	.comment-star.active svg path,
	.file-star.active svg path,
	.star.pernament-active svg path, 
	.star:hover svg path {
		fill: <?php echo get_option('ll_secondary_color','#4f83cc');?> !important;
	}
</style>