<?php

//[foobar]
function foobar_func( $atts ){
	return "foo and bar";
}
add_shortcode( 'foobar', 'foobar_func' );


//[bartag foo="foo-value"]
function bartag_func( $atts ) {
    $a = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );

    return "foo = {$a['bar']}";
}
add_shortcode( 'bartag', 'bartag_func' );

function fm_search_field_shortcode($atts) {
	$string = '
		<label>
			<input type="text" name="file-name" value="" placeholder="Vyhledávání">
		</label>
		<button type="submit">Hledat</button>
	';
	echo $string;
}
add_shortcode('fm_search','fm_search_field_shortcode');

/*function for display materials */
function fm_display_files($atts) {
    extract( shortcode_atts( array(
        //'parent' => 8,
        //'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<div class="files-items">';
    $args = array(
        //'post_parent' => $parent,
        'post_type' => 'materials',
        'posts_per_page' => $perpage,
        //'sort_column'   => 'menu_order'
    );
    $files_query = new  WP_Query( $args );
    while ( $files_query->have_posts() ) : $files_query->the_post();
    	$title = get_the_title();
        $output .= '<div class="file-item">'.
        				'<h3>' .$title .'</h3>' .
                   '</div><!--  ends here -->';
    endwhile;
    wp_reset_query();
    $output .= '</div>';
    return $output;
}
add_shortcode('fm_files_list','fm_display_files');

/*function for display keywords filter */
function fm_display_taxonomy_filter($atts) {
/*<ul><?php echo get_the_term_list( $post->ID, 'jobs', '<li class="jobs_item">', ', ', '</li>' ) ?></ul>;*/
    extract( shortcode_atts( array(
        'tax' => 8,
        //'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $terms = get_terms( $tax, array(
	    'hide_empty' => false,
	) );
	$output = '<div class="'.$tax.'-filter">';
 	if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
 	{
     
	     foreach ( $terms as $term ) {
	       $output .= '<li>' . $term->name . '</li>';
	     }//foreach

 	}//if
    $output .= '</div>';
    return $output;
}
add_shortcode('fm_tax_filter','fm_display_taxonomy_filter');



?>