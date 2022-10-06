<?php
echo '<div class="section searched-materials">';
	echo '<h2>Searched materials: </h2>';

		if (isset($_GET['pg']) && $_GET['pg'] != 0) {
			$page = $_GET['pg'];
		}else {
			$page = 1;
		}
		if (isset($_GET['file']) && $_GET['file'] != "") {
			$args = array(
				'customSearchTitle' => $_GET['file'],
				'post_type' => 'materials',
				// Order & Orderby Parameters
				'order'               => 'DESC',
				'orderby'             => 'date',
				'posts_per_page'	=> 10,
				'paged' => $page,
			);	
		}else {
			$args = array(
				'post_type' => 'materials',
				'order'               => 'DESC',
				'orderby'             => 'date',
				'posts_per_page'	=>  10,
				'paged' => $page,
			);	
		}

		$taxQueries = array();
		foreach ($_GET as $key => $item) {
			if ($key != 'file' && $key != 'pg' && $key != 'search') {
				array_push($taxQueries,array(
					'taxonomy' => $key,
					'field' => 'slug',
					'terms' => $item
				));
			}						
		}
		if (!empty($taxQueries)) {
			$args['tax_query'] = array('relation' => 'AND', $taxQueries);
		}

		$searchedMaterials = new WP_Query( $args );

		if ( $searchedMaterials->have_posts() ) {

			$foundString = '<p> Found <b>'.$searchedMaterials->found_posts.'</b>';
			if ($searchedMaterials->found_posts == 1) {
				$foundString .= ' material';
			}else{
				$foundString .= ' materials';
			}
			if (isset($_GET['file']) && $_GET['file'] != "" || !empty($taxQueries)) {
				$foundString .= ' with parametrs';
			}
			$foundString .= ':</p>';
			echo $foundString;

			echo '<div class="searched-filters">';
			if (isset($_GET['file']) && $_GET['file'] != '') {
				echo '<div class="taxonomy-wrap">';
					echo '<p class="taxonomy-title">File name: </p>';
					echo ' <span>'.$_GET['file'].'</span>';
				echo '</div>';
			}
			foreach ($taxQueries as $key => $tax) {

				$label = get_taxonomy( $tax['taxonomy'] )->label;
				echo '<div class="taxonomy-wrap">';
					echo '<p class="taxonomy-title">'.$label.': </p>';
				for ($i=0; $i < sizeof($tax['terms']); $i++) { 
					$termLabel = get_term_by( $field = 'slug' , $value = $tax['terms'][$i], $taxonomy = $tax['taxonomy'], $output = OBJECT, $filter = 'raw' )->name;
					echo ' <span>'.$termLabel.'</span>';
					if (sizeof($tax['terms']) > 1 && ($i+1) != sizeof($tax['terms'])) {
						echo ', ';
					}
				}
				echo '</div>';				
			}
				echo '<div class="edit-filters-btn fm-button">Edit filters</div>';		
			echo '</div>';
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