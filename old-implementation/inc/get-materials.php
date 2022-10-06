<?php

	/*$keyWords = $_GET['key-words'];
	$fileContentType = $_GET['file-content-type'];
	$targetGroups = $_GET['target-group'];
	$materialLang = $_GET['material-language'];
	$fileType = $_GET['file-type'];
	$materialAuthor = $_GET['material-author'];
	$institution = $_GET['institution'];	*/
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );

	// PŘEDĚLAT ABY VRACEL JSON MATERIÁLŮ !!!
?>
<p class="list-title">Search results: </p> <!--doplnit pocet vysledku-->

			<div class="files-items">
				<?php 	
					$taxs = get_object_taxonomies('materials','objects'); 
					$taxQueries = array();

					//foreach cyklus na naplneni tax query pomoci $_GET;
					foreach ($_GET as $key => $item) {
						//$key = taxonomie
						//$item = pole s hodnotama filtru pro taxonomii
						if ($key != 'file-name') {
							array_push($taxQueries,array(
								'taxonomy' => $key,
								'field' => 'slug',
								'terms' => $item
							));
						}						
					}

					//je vyplnenej nazev souboru
					if (!empty($_GET['file-name']) || isset($_GET['file-name'])) {
						$args = array(										
							// Type & Status Parameters
							's' => $_GET['file-name'],
							'post_type'   => 'materials',
							'post_status' => 'publish',
					
							// Order & Orderby Parameters
							'order'               => 'DESC',
							'orderby'             => 'date',
					
							// Pagination Parameters
							'posts_per_page'         => 10,
							//'paged'                  => get_query_var( 'paged' ),
							//'offset'                 => 3,
						
							// Taxonomy Parameters
							'tax_query' => ''		
						);
					}else {
						$args = array(										
							// Type & Status Parameters
							'post_type'   => 'materials',
							'post_status' => 'publish',
					
							// Order & Orderby Parameters
							'order'               => 'DESC',
							'orderby'             => 'date',
					
							// Pagination Parameters
							//'posts_per_page'         => 10,
							//'paged'                  => get_query_var( 'paged' ),
							//'offset'                 => 3,
						
							// Taxonomy Parameters
							'tax_query' => ''			
						);
					}

					if (!empty($taxQueries)) {
							$args['tax_query'] = array('relation' => 'AND', $taxQueries);
					}
					
					
				$filesQuery = new WP_Query( $args );


		if ( $filesQuery->have_posts() ){
			while ( $filesQuery->have_posts() ) : $filesQuery->the_post();
				
				$postTerms = array();
				$allTaxs = get_post_taxonomies(get_the_ID()); 
				/*init array*/
				foreach ($allTaxs as $tax) {
					//$tax = name 'key-words'
					$postTerms[$tax] = array();
				}

				/*fill array with data*/
				foreach ($taxs as $tax) {
					$terms = get_the_terms(get_the_ID(),$tax->name);//array of terms for post
					
					//print_r($terms);
					if (is_array($terms) || is_object($terms)) {
						foreach ($terms as $term) {
							array_push($postTerms[$tax->name], $term->name);
						}
					}
				}

				//print_r($postTerms);
				if ( has_post_thumbnail() ) {
					$url = get_the_post_thumbnail_url( get_the_ID(),'thumbnail' ); 
				}else {
					//defaultni image
				}
			?>
				<!--vypis souboru-->
				<div class="file-item">
					<div class="file-thumb" style="background-image: url('<?php echo $url;?>');"></div><!--file-thumb-->

					<div class="file-content">
						<span class="file-type-icon"><!--icon--></span>
						<h4 class="file-title"><?php echo the_title();?></h4>
						<span class="stars"><!--hodnoceni--></span>

						<span class="file-description">
							<?php the_content();?>
						</span>

						<div class="taxonomies">
		
							<?php 
								foreach ($taxs as $tax) { ?>
									<div class="taxonomy-row taxonomy-<?php echo $tax->name;?>-row">
										
										<?php
											if (!empty($postTerms[$tax->name])) { 
												if ( ($tax->name != 'material-language') && ($tax->name != 'file-content-type')) { ?>
													<p class="taxonomy-title"><?php echo $tax->label;?>:</p>
													<?php
														foreach ($postTerms[$tax->name] as $term) {
												 			echo '<span>'.$term.'</span>, ';
														}//foreach
												}
										?>			
										<?php }//if empty						 
										?>
									</div><!--taxonomy-row-->
							<?php
								}
							?>
						</div><!--taxonomies-->

						<a href="<?php the_permalink();?>" class="fm-button">View</a>
					</div><!--file-content-->

					
				</div><!--file-item-->
				
			<?php endwhile; 
		}else { ?>
			<p>Sorry, nothing found.</p>
		<?php } ?>