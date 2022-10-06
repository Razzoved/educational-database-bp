<?php
/**
 * Template Name: Page for display all materials
 *
 * @package WordPress
 */
$upload_dir = wp_upload_dir();
get_header();?>

	<div class="ll-container clearfix page-all-materials">

		<?php 
			/* -- TODO: MOŽNOST NASTAVENÍ JESTLI ZOBRAZIT NAHOŘE NEBO DOLE */
			include('materials-search-form.php');
			if (isset($_GET['search']) && $_GET['search'] == 1) {
				include('searched-materials-list.php');
			}elseif(isset($_GET['all']) && $_GET['all'] == 1) {
				include('all-materials-list.php');
			}else {
				if (get_option('ll_is_top_materials_allow')) {
					include('top-rated-materials.php');
				}

				if (get_option('ll_is_newest_materials_allow')) { 
					include('new-materials.php');	
				}				
							
			}

		?>
		
		<div class="project-info">
      <img src="https://www.academicintegrity.eu/wp/wp-content/uploads/2017/01/eu_flag_co_funded_pos_rgb_left-300x86.jpg" class="image wp-image-103  attachment-medium size-medium" alt="" style="max-width: 100%; height: auto;" srcset="https://www.academicintegrity.eu/wp/wp-content/uploads/2017/01/eu_flag_co_funded_pos_rgb_left-300x86.jpg 300w, https://www.academicintegrity.eu/wp/wp-content/uploads/2017/01/eu_flag_co_funded_pos_rgb_left-768x219.jpg 768w, https://www.academicintegrity.eu/wp/wp-content/uploads/2017/01/eu_flag_co_funded_pos_rgb_left-1024x292.jpg 1024w" sizes="(max-width: 300px) 100vw, 300px" width="300" height="86">
        <p>European Network for Academic Integrity was supported by the Erasmus+ Strategic Partnerships project 2016-1-CZ01-KA203-023949.</p>
    </div>
		
	</div><!--/container-->

<?php 
	wp_reset_query();
?>

<?php get_footer( );?>
