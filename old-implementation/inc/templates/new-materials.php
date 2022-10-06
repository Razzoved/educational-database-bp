<?php
echo '<div class="section top-materials">';
	echo '<h2>New materials: </h2>';
		if (!isset($taxonomies)) {
			$taxonomies = get_object_taxonomies('materials','object');
		}
		$args = array(
			'post_type' => 'materials',
			'order'               => 'DESC',
			'orderby'             => 'date',
			'posts_per_page'	=> get_option('ll_new_materials_count', '5')
		);		
		$bestsMaterials = new WP_Query( $args );

		while ( $bestsMaterials->have_posts() ) : $bestsMaterials->the_post();
			include('material-item-template.php');
		endwhile; 
echo '</div>';
?>
