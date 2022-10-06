<?php 
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );

	$args = array(										
		// Type & Status Parameters
		's' => $_POST['file-name'],
		'post_type'   => 'materials',
		'post_status' => 'publish',
		'post__not_in' => $_POST['exclude'],

		// Order & Orderby Parameters
		'order'               => 'DESC',
		'orderby'             => 'name',		
	);

	$filesQuery = new WP_Query( $args );

	if ( $filesQuery->have_posts() ){
			while ( $filesQuery->have_posts() ) : $filesQuery->the_post();
				echo '<li class="related-file" data-id="'.get_the_ID().'" data-link="'.get_the_permalink().'">';
					the_title();
				echo '</li>';				
			endwhile; 
		}else { ?>
			<p>Sorry, nothing found.</p>
<?php } 
?>
