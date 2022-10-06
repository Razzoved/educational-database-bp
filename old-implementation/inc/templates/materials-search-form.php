	<?php /* TODO: Změnit id na nastavitelný */ 
		if (!isset($taxonomies)) {
			$taxonomies = get_object_taxonomies('materials','object');
		}
	
	echo '<form action="'.get_permalink(get_option( 'll_main_page_id')).'" id="file-search-form">';
		echo '<h2 class="search-title">Search materials:</h2>'; 
	
		echo '<div class="search-input-wrap">';
			echo '<span class="dashicons dashicons-search"></span>';

			if (isset($_GET['file']) && $_GET['file'] != '') {
				echo '<input type="text" name="file" class="file-name fm-input" placeholder="File name" value="'.$_GET['file'].'">';
			}else {
				echo '<input type="text" name="file" class="file-name fm-input" placeholder="File name">';
			}

			echo '<input type="submit" class="fm-button" id="fm-filter-btn" value="Search">';
			if (!(isset($_GET['search']) && $_GET['search'] == '1')) {
				echo '<div class="show-filters-btn fm-button">Show filters</div>';
			}	
			if (!(isset($_GET['all']) && $_GET['all'] == 1)) {
				echo '<a href="'.get_permalink(get_option( 'll_main_page_id')).'?all=1" class="fm-button">All materials</a>';
			}			
		echo '</div>';
		

		echo '<div class="filters-popup">';
			echo '<div class="popup-divider"></div>';
			echo '<div class="filters-wrap">';
					echo '<div class="popup-close clearfix">';
						include(WP_PLUGIN_DIR.'/e-learning-file-manager/img/close.svg');
					echo '</div>';
				echo '<div class="inner">';
					foreach ($taxonomies as $tax) {
						$i = 1;
						$terms = get_terms( $tax->name, array(
							    'hide_empty' => false,
							    'orderby' => 'name', 
								) );
						$taxLabels = get_taxonomy_labels($tax);
						$customLabels = ["File content types" => "Material type", "Recommendes"=> "Recommendations"];
						$label = array_key_exists($tax->label, $customLabels) ? $customLabels[$tax->label] : $tax->label;

						echo '<div class="tax-filter-row tax-'.$tax->name.'">';
							echo '<p class="tax-filter-title">'.$label.'</p>';
							foreach ($terms as $term) {
								if (array_key_exists($tax->name, $_GET)) {
									if (in_array($term->slug, $_GET[$tax->name])) {
										$checked = 'checked';
									}else {
										$checked = '';
									}
								}

								if ($i > 3 && $checked == "") {
									$class= "hidden-item";
								}else {
									$class=" ";
								}

								echo '<p class="tax-input '.$class.'">';
									echo '<input type="checkbox" id="'.$term->slug.'" name="'.$tax->name.'[]" value="'.$term->slug.'" '
									. $checked.'>';
									echo '<label class="tax-label" for="'.$term->slug.'">'. $term->name.'</label>';
								echo '</p>';
								$i++;							
							}
						echo '</div>';
					}//foreach taxonomies

					echo '<input type="hidden" name="search" value="1">';
					echo '<div class="buttons">';
						echo '<button class="reset-filters-btn fm-button">Reset filters</button>';
						echo '<button type="submit" class="fm-filter-btn fm-button" id="fm-filter-btn">Search</button>';
					echo '</div>';
				echo '</div>';//inner
			echo '</div>';//filtres wrap
		echo '</div>';//popup
			
	echo '</form>';