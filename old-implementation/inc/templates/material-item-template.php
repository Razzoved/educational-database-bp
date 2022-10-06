<?php
$materialID = get_the_ID();
$materialTitle = get_the_title($materialID);

if (isset($bestsAvg)) {
	$avgRate = round($bestsAvg[$materialID]);
}else {
	$avgRate = fm_count_avgRate($materialID);
}

global $wpdb;
//dotaz získa z databaze všechny taxonomie s termy pro danný post => místo 6 dotazu pro každý post, je jenom jeden
$material_taxonomies_query = $wpdb->get_results( "SELECT {$wpdb->prefix}terms.term_id,name, slug, object_id as post_id, taxonomy FROM {$wpdb->prefix}terms join {$wpdb->prefix}term_relationships on term_taxonomy_id = {$wpdb->prefix}terms.term_id JOIN {$wpdb->prefix}term_taxonomy on {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}terms.term_id where object_id = {$materialID}", ARRAY_A );

$material_taxonomies = array();
if (!isset($taxonomies)) {
	$taxonomies = get_object_taxonomies('materials','object');
}
foreach ($taxonomies as $tax) {
	$material_taxonomies[$tax->name]['label'] = $tax->label;
}
foreach ($material_taxonomies_query as $tax_row) {
	$material_taxonomies[$tax_row['taxonomy']]['terms'][] = $tax_row['name'];
}

/*Počet zobrazení*/
$views = ll_get_post_views($materialID);
$perex = truncate(strip_tags(get_the_content()), 200);

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

echo '<a href="'.get_the_permalink().'" class="material-item" id="'.$materialID.'">';
	if ( has_post_thumbnail($materialID) ) {
		$thumbURL = get_the_post_thumbnail_url($materialID,"thumbnail");
		echo '<img src="'.$thumbURL.'" alt="'.$materialTitle.'" class="material-thumb">';
	}else {
		echo '<div class="material-thumb dashicons '.$dashClass.'"></div>';
	}
	
	echo '<article class="material-description">';
		echo '<header class="metarial-header">';
			echo '<p class="material-title">'.$materialTitle.'</p>';
			echo '<p class="material-date">'.get_the_date('d. m. Y').'</p>';
			echo '<div class="material-rate">';
						for ($i=0; $i < 5; $i++) { 
							if ($i+1 <= $avgRate) {
								$class="active";
							}else {
								$class="";
							}
							echo '<div class="file-star '.$class.'">';
								include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/star.svg');
							echo '</div>';
						} 
			echo '</div>';			
		echo '</header>';

		echo '<div class="material-taxonomies">';
			foreach ($material_taxonomies as $tax) {				
				if (isset($tax['terms']) && $tax['label'] == 'File type') { // odmazat $tax[label] .. pred odevzdanim
					echo '<div class="taxonomy-wrap">';
						echo '<p class="taxonomy-title">'.$tax['label'].': </p>';
						for ($i=0; $i < sizeof($tax['terms']); $i++) { 
							echo ' <span>'.$tax['terms'][$i].'</span>';
							if (sizeof($tax['terms']) > 1 && ($i+1) != sizeof($tax['terms'])) {
								echo ', ';
							}
						}
					echo '</div>';
				}
			}
		echo'</div>';
		
		echo '<div class="material-excerpt">'.$perex.'</div>';

		echo '<div class="links-wrap">';
			echo '<p class="material-views">Viewed: '.$views.'x</p>';
			echo '<span href="'.get_the_permalink().'" class="fm-button">Detail</span>';
		echo '</div>';
	echo '</article>';
echo '</a>';