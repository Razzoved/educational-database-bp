<?php
/**
 * Template Name: Page for display all materials
 *
 * @package WordPress
 */

get_header();
while ( have_posts() ) : the_post(); 
$taxonomies = get_object_taxonomies('materials','object');?>

	<div class="ll-container clearfix page-all-materials">

		<?php 
			/* -- TODO: MOŽNOST NASTAVENÍ JESTLI ZOBRAZIT NAHOŘE NEBO DOLE */
			include('materials-search-form.php');
			if (isset($_GET['search']) && $_GET['search'] == 1) {
				include('searched-materials-list.php');
			}elseif(isset($_GET['all']) && $_GET['all'] == 1) {
				include('materials-list.php');
			}else {
				if (get_option('ll_is_top_materials_allow')) {
					include('top-rated-materials.php');
				}

				if (get_option('ll_is_newest_materials_allow')) { 
					include('new-materials.php');	
				}
				
							
			}

		?>
	</div><!--/container-->

<?php 
	endwhile; 
	wp_reset_query();
?>

<?php get_footer( );?>
