<?php
 echo '<div class="section searched-materials">';
	echo '<h2>All materials: </h2>';

	if (isset($_GET['pg']) && $_GET['pg'] != 0) {
		$page = $_GET['pg'];
	}else {
		$page = 1;
	}

	$args = array(
		//'s' => $_GET['file'],
		'post_type' => 'materials',
		// Order & Orderby Parameters
		'order'               => 'DESC',
		'orderby'             => 'date',
		'posts_per_page'	=>  10,
		'paged' => $page,
	);	


	$searchedMaterials = new WP_Query( $args );
	if ( $searchedMaterials->have_posts() ) {
		while ( $searchedMaterials->have_posts() ) : $searchedMaterials->the_post();
			include('material-item-template.php');
		endwhile; 
	}else {
		echo '<p>Nothing found</p>';
	}
	wp_reset_query();
	if (isset($_GET['pg']) && $_GET['pg'] != 0) {
		$page = $_GET['pg'];
	}else {
		$page = 1;
	}
	echo '<div class="fm-page-nav">';
		$args = array(
			'total'              => $searchedMaterials->max_num_pages,
			'current'            => $page,
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => false,
			'add_args'           => true,
			'base'               => '%_%',
			'format'             => '?pg=%#%',
		);
		echo paginate_links( $args );
	echo '</div>';
	echo '<script>';
		echo 'jQuery(".page-numbers").first().attr("href", "?pg=1&all=1");';
	echo '</script>';

echo '</div>';