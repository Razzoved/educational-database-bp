<?php
	
	/*Funkce přidá meta boxy do administrační části materiálu*/
	add_action( 'add_meta_boxes', 'fm_add_material_meta_boxes' );
	function fm_add_material_meta_boxes()
	{	
		/*add_meta_box( 
						string $id, - * id metaboxu
						string $title, - * titulek metaboxu
						callable $callback, - * funkce, která naplní meta box
						string|array|WP_Screen $screen = null, - obrazovky, kde se má meta box objevit (post type)
						string $context = 'advanced',  - místo, kde se má materiál zobrazit (pod contentem, vpravo, advaced)
						string $priority = 'default', - priorita, kde se má meta box zobrazit (high, default, low)
						array $callback_args = null  - parametry funkce, tkerá se volá
					)*/
		/*Meta box pro checkbox s umístěním + soubor nebo link*/
		add_meta_box('material-files-info','Files','fm_material_files_info_metabox', 'materials', 'normal', 'high');
	    add_meta_box( 'addition-information', 'Another information of material', 'fm_additional_info', 'materials', 'normal', 'high' );
	    add_meta_box( 'related-files', 'Related files', 'fm_related_files', 'materials', 'normal', 'low' );
	}

	/*Funkce na vykreslení meta boxu*/
	function fm_material_files_info_metabox($post) {
		wp_enqueue_media(); //je potřeba pro vytvoření media loaderu
		global $post; //obsahuje informace o současném postu (koncept už má taky id)
		$materialID = $post->ID;
		$materialFilesMeta = get_post_meta($materialID, 'material_files');
		$materialPlacement = get_post_meta($materialID, 'placement', true);
		if (!empty($materialFilesMeta)) {
			$materialFilesID = $materialFilesMeta[0];
		}

		$externalHideStyle = '';
		$selectedHideStyle = '';
		$externalFileLink = '';
		$checkedInternal = '';
		$externalFileLink = '';
		$checkedExternal = '';
		if ($materialPlacement == "" || $materialPlacement == 'internal') {
			$externalHideStyle = 'style="display: none;"';
			$checkedInternal = 'checked';
		}elseif ($materialPlacement == 'external') {
			$selectedHideStyle = 'style="display: none;"';
			$externalFileLink = get_post_meta($materialID, 'file-link', true);
			$checkedExternal = 'checked';
		}
		echo '<p><strong>Material storage</strong></p>';
		echo '<p class="meta-box-hint">Select if material is to download or only link to another website.</p>';
		echo '<p><label for="placementInternal"><input type="radio" id="placementInternal" name="placement" value="internal" '.$checkedInternal.'>Material to download (internal)</label></p>';
		echo '<p><label for="placementExternal"><input type="radio" id="placementExternal" name="placement" value="external" '.$checkedExternal.'>Link to website (external)</label></p>';

		/* TODO: dodělat možnost popup okna pro editaci filu, nezobrazuje se správná ikonka po aktulazici (ani u detailu) */
		echo '<div id="selected-files" '.$selectedHideStyle.'>';
			wp_reset_query();
			if (!empty($materialFilesID)) {
				$args = array(
					'post_type' => 'attachment',
				    'post__in' => $materialFilesID
				);
				$files = get_posts($args);
				foreach ($files as $file) {
					$type = $file->post_mime_type;
					if ($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif' && $type !="	application/pdf") {
						//$thumb = wp_mime_type_icon($type);
						$thumb = fm_get_dashicon_from_mime_type($type);
					}else {
						$thumbURL = wp_get_attachment_image_url($file->ID, 'thumbnail');
						$thumb = '<img src="'.$thumbURL.'">';
					}
					echo '<div class="select-file" id="'.$file->ID.'">';
						echo '<p class="file-title">'.$file->post_title.'</p>';
						echo '<div class="select-file-thumb">';
							echo $thumb;
							echo '<div class="delete-file-btn" data-id="'.$file->ID.'"></div>';
						echo '</div>'; 
						echo '<input type="hidden" name="files-id[]" value="'.$file->ID.'">';
					echo '</div>';
				}//$files
			}
		echo '</div>';
		echo '<div id="external-link" '.$externalHideStyle.'>';
			if ($checkedExternal == 'checked') {
				echo '<p><label>Link to material: <input type="text" name="file-link" value="'.$externalFileLink.'" placeholder="https://www.google.com/" required="required"></label></p>';
			}else {
				echo '<p><label>Link to material: <input type="text" name="file-link" value="'.$externalFileLink.'" placeholder="https://www.google.com/"></label></p>';
			}
		echo '</div>';
	
		/*Políčka pro soubory (buď Add media (download) nebo políčko pro link)*/
		echo '<p class="hide-if-no-js">';
			if (!empty($materialFilesID)) {
				echo '<a id="insert-file-btn" class="button button-primary" '.$selectedHideStyle.'>Add files</a>';
			}else {
				echo '<a id="insert-file-btn" class="button button-primary" '.$selectedHideStyle.'>Insert files</a>';
			}
		echo '</p>';
	}//fm_material_files_info_metabox


	/*Function rendering metabox with additional information about material*/
	function fm_additional_info( $post)	{
		global $post;

	    $values = get_post_custom( $post->ID ); //ziska pole custom meta podle id postu
	    $materialSender = isset( $values['_material-sender'] ) ? $values['_material-sender'][0] : '';
	    $selected = isset( $values['placement'] ) ? esc_attr( $values['placement'][0] ) : '';

	    //print_r($values);
	?>
	    	<!--<div id="placement-material">
	    		<strong>Placement of material</strong><br>
	    			<p>Chcked where is material stored.</p>
	    			<label for="placementInternal"><input type="radio" id="placementInternal" name="placement" value="internal" <?php checked( $selected, 'internal' ); ?> >Internal (on our server)<label> <br>
	    			<label for="placementExternal"><input type="radio" id="placementExternal" name="placement" value="external" <?php checked( $selected, 'external' ); ?>> External link<label><br>
	    	</div><br>-->

	    	<div id="material-sender">
	    		<strong>Material sender * </strong><br>
	    			<p>Fill name who the material send.</p>
	    			<label for="material-sender">Name: <input type="text" name="material-sender" value="<?php echo $materialSender; ?>" required='required'></label>
	    	</div>	
	<?php } //another information


	function fm_related_files( $post) {
	?>
		<p>Select related materials</p>

		<input type="hidden" name="ajax-url" value="<?php echo plugins_url( "/search-for-related.php", __DIR__);?>">
		<input type="hidden" name="materialID" value="<?php echo $post->ID;?>">
			<div id="files-name-box">

				<div class="search-box">
					<input type="text" name="rlt-file-title" id="rlt-file-title" placeholder="Material title">
					<a class="button" id="search-files-btn">Search</a>				
				</div>


				<ul id="searched-files-select">
					<?php 
						$relFiles = get_post_meta($post->ID,'related_files',true);
						$args = array(										
							// Type & Status Parameters
							//'s' => $_POST['file-name'],
							'post_type'   => 'materials',
							'post_status' => 'publish',

							// Order & Orderby Parameters
							'order'               => 'DESC',
							'orderby'             => 'name',	
							'posts_per_page'	=> -1
						);

						$filesQuery = new WP_Query( $args );
						/* TODO: schovat již přidaný a udělat jako link */
						if ( $filesQuery->have_posts() ){
								while ( $filesQuery->have_posts() ) : $filesQuery->the_post();
										$fileID = get_the_ID();
										if ($fileID != $post->ID && (!in_array($fileID, $relFiles))) { ?>
											<li class="related-file" data-id="<?php echo get_the_ID();?>"  data-link="<?php echo get_the_permalink();?>">
												<?php the_title();?>
											</li>
										<?php }
									?>
									
								<?php endwhile; 
							}else { ?>
								<p>Sorry, nothing found.</p>
					<?php } ?>
				</ul>					
			</div>

			
			<div id="selected-files-list">
				<p style="font-weight: 600;">Selected materials</p>
				<?php 
					

					if (!empty($relFiles)) {
						foreach ($relFiles as $file) {
							echo '<label for="selected-file">';
								echo '<a href="'.get_the_permalink($file).'" target="_blank" class="related-title">';
								echo get_the_title($file);
								echo '</a>';
								echo '<input type="hidden" value="'.$file.'"  name="selected-files[]">';
								echo '<div class="delete-related-btn"></div>';
							echo '</label>';
						}
					}else {
						echo "<p>Material hasn't related items.</p>";
					}					
				?>

				<!--pole vybranych souboru-->
				<!--<label for="selected-file">Jméno příspěvku
					<input type="hidden" value="id-prispevku" name="selected-files[]">
					<div class="delete-button"></div>
				</label> -->
			</div>						




	<?php }//related files

	function sample_admin_notice__success() {
	    ?>
	    <div class="notice notice-success is-dismissible">
	        <p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
	    </div>
	    <?php
	}
	/*function saving information from metabox with additional information about material*/
	add_action( 'save_post', 'fm_save_additional_info' );

	function fm_save_additional_info( $post_id ){
        /* Uložení id souborů k materiálu */
        if(isset($_POST['files-id'])) {
	    	foreach ($_POST['files-id'] as $fileID) {
	    		$ids[] = esc_attr($fileID);
	    	}
	    	if(! add_post_meta($post_id, 'material_files', $ids, true)) {
	    		update_post_meta($post_id, 'material_files', $ids);
	    	}
	    }

	    if( isset( $_POST['material-sender'] ) ) {
	    	if ( ! add_post_meta( $post_id, '_material-sender',  esc_attr($_POST['material-sender']), true ) ) { 
			   update_post_meta( $post_id, '_material-sender', esc_attr($_POST['material-sender']) );
			}
	    }
	    // wordpress nezobrazi meta začínající _ když použiji funkci the_meta();

	    if( isset( $_POST['file-link'] ) ) {
	    	if ( ! add_post_meta( $post_id, 'file-link',  esc_attr($_POST['file-link']), true ) ) { 
			   update_post_meta( $post_id, 'file-link', esc_attr($_POST['file-link']) );
			}
	    }

	    if( isset( $_POST['placement'] ) ) {
	    	if ( ! add_post_meta( $post_id, 'placement',  esc_attr($_POST['placement']), true ) ) { 
			   update_post_meta( $post_id, 'placement', esc_attr($_POST['placement'] ));
			}
	    }

	    if ($_POST['placement'] == 'external' && $_POST['file-link'] == '') {
	    }


	    /*if( isset( $_POST['custom-img-id'] ) ) {
	    	if ( ! add_post_meta( $post_id, 'material_file',  esc_attr($_POST['custom-img-id']), true ) ) { 
			   update_post_meta( $post_id, 'material_file', esc_attr($_POST['custom-img-id'] ));
			}
	    } */

	    if( isset( $_POST['selected-files'] ) ) {
	    	foreach ($_POST['selected-files'] as $fileID) {
	    		$rel_ids[] = esc_attr($fileID);
	    	}
	    		if ( ! add_post_meta( $post_id, 'related_files',  $rel_ids, true ) ) { 
				   update_post_meta( $post_id, 'related_files',  $rel_ids);
				}
	    }else {
	    	$rel_ids = array();
	    	if ( ! add_post_meta( $post_id, 'related_files',  $rel_ids, true ) ) { 
			   update_post_meta( $post_id, 'related_files',  $rel_ids);
			}
	    }       
	}//save additional info

?>