<?php
/**
 * Template Name: Page template
 *
 * @package WordPress
 */

get_header(); 
ll_set_post_view(get_the_ID());
$taxonomies = get_object_taxonomies('materials','object');

while ( have_posts() ) : the_post(); 

	echo '<div class="ll-container clearfix single-material material-'.get_the_ID().'">';
		$materialID = get_the_ID();
		$materialTitle = get_the_title($materialID);
		$materialDate = get_the_date('d. m. Y');
		global $wpdb;
		$material_taxonomies_query = $wpdb->get_results( "SELECT {$wpdb->prefix}terms.term_id,name, slug, object_id as post_id, taxonomy FROM {$wpdb->prefix}terms join {$wpdb->prefix}term_relationships on term_taxonomy_id = {$wpdb->prefix}terms.term_id JOIN {$wpdb->prefix}term_taxonomy on {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}terms.term_id where object_id = {$materialID}", ARRAY_A );

		$material_taxonomies = array();
		foreach ($taxonomies as $tax) {
			$material_taxonomies[$tax->name]['label'] = $tax->label;
		}		
		foreach ($material_taxonomies_query as $tax_row) {
			$material_taxonomies[$tax_row['taxonomy']]['slugs'][] = $tax_row['slug'];
			$material_taxonomies[$tax_row['taxonomy']]['terms'][] = $tax_row['name'];
		}

		$file_types = $material_taxonomies['file-type'];
		if (isset($file_types['terms'])) {
			$fileType = $file_types['terms'][0];

			if ($fileType == 'Presentation') {
				$dashClass = 'dashicons-media-interactive';
			}else if($fileType == 'Document') {
				$dashClass = 'dashicons-media-text';
			}else if($fileType == 'Video') {
				$dashClass = 'dashicons-media-video';
			}else if($fileType == 'Image') {
				$dashClass = 'dashicons-media-image';
			}else if($fileType == 'Voice') {
				$dashClass = 'dashicons-controls-volumeon';
			}else {
				$dashClass = 'dashicons-media-document';
			}
		}else {
			$dashClass = 'dashicons-media-document';
		}

		/*Počet zobrazení*/
		$views = ll_get_post_views($materialID);

		/* Comments + avg rate */
		$args = array(
			'orderby' => 'comment_date',
			'order' => 'DESC',
			'post_id' => $materialID,
			'status' => 'all',
		);
		$comments = get_comments( $args ); 

		if (!empty($comments)) {
			$commnets_count = sizeof($comments);
			$material_sum_stars_query = $wpdb->get_results( "SELECT SUM({$wpdb->prefix}commentmeta.meta_value) as sum FROM {$wpdb->prefix}commentmeta join {$wpdb->prefix}comments on {$wpdb->prefix}comments.comment_ID = {$wpdb->prefix}commentmeta.comment_ID where meta_key = 'stars' and comment_post_ID = {$materialID} GROUP BY comment_post_ID", ARRAY_A  );
			$material_sum_stars = $material_sum_stars_query[0]['sum'];
			$avg_rate = $material_sum_stars/$commnets_count;
		}

		echo '<div class="material-top-section">';
			$materialPlacement = get_post_meta($materialID, 'placement', true);
			if ($materialPlacement == 'external') {
				$material_link = get_post_meta($materialID, 'file-link', true);
				echo '<a href="'.$material_link.'">';
			}

			if ( has_post_thumbnail($materialID) ) {
				$thumbURL = get_the_post_thumbnail_url($materialID,"thumbnail");
				echo '<img src="'.$thumbURL.'" alt="'.$materialTitle.'" class="material-thumb">';
			}else {
				echo '<div class="material-thumb dashicons '.$dashClass.'"></div>';
			}

			if ($materialPlacement == 'external') {
				echo '</a>';
			}

		echo '<header class="material-header">';
			if (get_option('ll_main_page_id','00') == '00') {
				echo '<a href="/materials" class="fm-button back-button top"><< Materials list</a>';
			}else {
				echo '<a href="'.get_permalink(get_option( 'll_main_page_id')).'" class="fm-button back-button top"><< Materials list</a>';
			}
			echo '<p class="material-title">'.$materialTitle.'</p>';
			echo '<p class="material-date">'.$materialDate.'</p>';
			echo '<div class="material-rate">';
						for ($i=0; $i < 5; $i++) { 
							if ($i+1 <= $avg_rate) { /* TODO: dostat avgrante */
								$class="active";
							}else {
								$class="";
							}
							echo '<div class="file-star '.$class.'">';
								include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/star.svg');
							echo '</div>';
						} 
			echo '</div>';//material-rate	
			echo '<div class="material-taxonomies clearfix">';
			foreach ($material_taxonomies as $key => $tax) {		
				if (isset($tax['terms'])) {
					echo '<div class="taxonomy-wrap">';
					echo '<p class="taxonomy-title">'.$tax['label'].': </p>';
					for ($i=0; $i < sizeof($tax['terms']); $i++) { 
						echo ' <a href="'.get_permalink(get_option( 'll_main_page_id')).'/?'.$key.'[]='.$tax['slugs'][$i].'&search=1">'.$tax['terms'][$i].'</a>';
						if (sizeof($tax['terms']) > 1 && ($i+1) != sizeof($tax['terms'])) {
							echo ', ';
						}
					}
					echo '</div>';
				}
			}
		echo'</div>';	
		echo '</header>';
	echo '</div>';		


	echo '<div class="file-description">';
		the_content();
	echo '</div>';
		
	echo '<div class="section download">';
		if ($materialPlacement == 'internal') {
			$materialFilesMeta = get_post_meta($materialID, 'material_files');
			if (!empty($materialFilesMeta)) {
				$materialFilesID = $materialFilesMeta[0];

				if (!empty($materialFilesID)) {
					echo '<div class="material-file-items">';
						echo '<h2>Material files: </h2>';
						$args = array(
							'post_type' => 'attachment',
						    'post__in' => $materialFilesID
						);
						$files = get_posts($args);
						foreach ($files as $file) {
							echo '<a href="'.$file->guid.'" class="material-file-item" id="'.$file->ID.'">';
								echo '<p class="file-title">'.$file->post_title.'</p>';
								echo '<div class="file-item-download-cell">';
									echo '<span href="'.$file->guid.'" class="download-icon">';
										include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/download.svg');
									echo '</span>';
								echo '</div>';
							echo '</a>';
						}//$files
					echo '</div>';
				}

			}
		}elseif ($materialPlacement == 'external') {
			echo '<a href="'.$material_link.'" class="fm-button" target="_blank">View material</a>';
		}			
	echo '</div>';

	echo '<div class="section related-files-section">';
		echo '<h2>Related materials:</h2>';
		$rel_files_array = get_post_meta(get_the_ID(),'related_files',true); //pole ID materiálů

		if (!empty($rel_files_array)) {
			$args = array(
				'post_type' => 'materials',
				'post__in'     => $rel_files_array,
			);
		
			$related_files = new WP_Query( $args );

			if ($related_files->have_posts()) {
				echo '<div class="related-files-items">';
				while ($related_files->have_posts()) {
					$related_files->the_post();

					$rel_id = get_the_ID();
					$rel_title = get_the_title($rel_id);
					$rel_type = wp_get_post_terms( $rel_id, $taxonomy = 'file-type');

					if (!empty($rel_type)) {
						$fileType = $rel_type[0]->name;
						if ($fileType == 'Presentation') {
							$dashClass = 'dashicons-media-interactive';
						}else if($fileType == 'Document') {
							$dashClass = 'dashicons-media-text';
						}else if($fileType == 'Video') {
							$dashClass = 'dashicons-media-video';
						}else if($fileType == 'Image') {
							$dashClass = 'dashicons-media-image';
						}else if($fileType == 'Voice') {
							$dashClass = 'dashicons-controls-volumeon';
						}else {
							$dashClass = 'dashicons-media-document';
						}
					}else {
						$dashClass = 'dashicons-media-document';
					}

					echo '<a href="'.get_permalink( $rel_id).'" class="related-file-item">';
						echo '<div class="related-file-thumb">';
								if ( has_post_thumbnail($rel_id) ) {
									$thumbURL = get_the_post_thumbnail_url($rel_id,"thumbnail");
									echo '<img src="'.$thumbURL.'" alt="'.$materialTitle.'">';
								}else {
									//doplnit ikonky
									echo '<div class="material-thumb dashicons '.$dashClass.'"></div>';
								}
						echo '</div>';
						echo '<p class="title">'.$rel_title.'</p>';
						//echo '<div class="fm-button">View</div>';
					echo '</a>';
					
				}
				echo '</div>';
			}else {
				/* TODO: dodělat doplňování na základě tagů*/
				echo "<p>No related materials found.</p>";
			}
		}else {
			/* TODO: dodělat doplňování na základě tagů*/
			echo "Material hasn't related materials.";
		}
	echo '</div>';

	// echo '<div class="section comments-section" id="comments">';
	// 	if (!empty($comments)) {
	// 		echo '<h2>Material comments: </h2>';
	// 		echo '<div class="comments-items">';

	// 			if (isset($_GET['msg'])) {
	// 				if ($_GET['msg'] == 'added') {
	// 					echo '<p class="msg success">Comment was added.</p>';
	// 				}elseif ($_GET['msg'] == 'robot') {
	// 					echo '<p class="msg warning">Are you a robot?</p>';
	// 				}
	// 			}

	// 		$commnets_count = sizeof($comments);
	// 		foreach ($comments as $comment) {
	// 			$comment_star = 0;
	// 			if (!empty(get_comment_meta( $comment->comment_ID, 'stars'))) {
	// 				$comment_star = get_comment_meta( $comment->comment_ID, 'stars' )[0];
	// 			}
	// 			echo '<div class="comment-item">';
	// 				// TODO: Dodělat gravatar 

	// 				echo '<div class="comment-header">';
	// 					echo '<img src="'.plugins_url() . '/e-learning-file-manager/img/avatar.png" alt="">';
	// 					echo '<span>';
	// 						echo '<p class="author-comment-name">'.$comment->comment_author.'</p>';
	// 						echo '<p class="comment-date">'.date ( 'j. n. Y - H:i' , strtotime($comment->comment_date) ).'</p>';
	// 						echo '<div class="material-rate">';
	// 						for ($i=0; $i < 5; $i++) {
	// 							if ($i+1 <= $comment_star) {
	// 							echo '<div class="comment-star active">';
	// 							}else {
	// 							echo '<div class="comment-star">';
	// 							}
	// 								include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/star.svg');
	// 							echo '</div>';
								
	// 						}
	// 						echo '</div>';	
	// 					echo '</span>';
	// 				echo '</div>';
	// 				if ($comment->comment_content) {
	// 					echo '<div class="comment-content">';	
					
	// 						echo '<p>'.$comment->comment_content.'</p>';
	// 					echo '</div>';//comment-content
	// 				}

	// 			echo '</div>';//comment-item
	// 		}
	// 		echo '<div>';
	// 	}else {
	// 		//no comments
	// 	}	

		// include(WP_PLUGIN_DIR.'/e-learning-file-manager/inc/templates/custom-comment-form.php');;
	// echo '</div>';
		
	if (get_option('ll_main_page_id','00') == '00') {
		echo '<a href="/materials" class="fm-button back-button"><< Materials list</a>';
	}else {
		echo '<a href="'.get_permalink(get_option( 'll_main_page_id')).'" class="fm-button back-button"><< Materials list</a>';
	}
echo '</div>';

endwhile; 
wp_reset_query();


get_footer( );?>
