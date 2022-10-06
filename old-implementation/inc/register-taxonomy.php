<?php
/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function key_words_taxonomy() {

	$labels = array(
		'name'                  => _x( 'Key words', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Key word', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search key words', 'text-domain' ),
		'popular_items'         => __( 'Popular key words', 'text-domain' ),
		'all_items'             => __( 'All key words', 'text-domain' ),
		'edit_item'             => __( 'Edit key word', 'text-domain' ),
		'update_item'           => __( 'Update key word', 'text-domain' ),
		'add_new_item'          => __( 'Add New key word', 'text-domain' ),
		'new_item_name'         => __( 'New key word', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove key words', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used key words', 'text-domain' ),
		'menu_name'             => __( 'Key words', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);
	register_taxonomy( 'key-words', array( 'materials', 'post' ), $args );
}

add_action( 'init', 'key_words_taxonomy' );
/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function languages_taxonomy() {

	$labels = array(
		'name'                  => _x( 'Material languages', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Material language', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search material languages', 'text-domain' ),
		'popular_items'         => __( 'Popular material languages', 'text-domain' ),
		'all_items'             => __( 'All material languages', 'text-domain' ),
		'edit_item'             => __( 'Edit material language', 'text-domain' ),
		'update_item'           => __( 'Update material language', 'text-domain' ),
		'add_new_item'          => __( 'Add New material language', 'text-domain' ),
		'new_item_name'         => __( 'New Singular material language', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove material languages', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used material languages', 'text-domain' ),
		'menu_name'             => __( 'Material languages', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);
	register_taxonomy( 'material-language', array( 'materials' ), $args );
}

add_action( 'init', 'languages_taxonomy' );

/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function file_content_taxonomy() {

	$labels = array(
		'name'                  => _x( 'File content types', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'File content type', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search File content types', 'text-domain' ),
		'popular_items'         => __( 'Popular File content types', 'text-domain' ),
		'all_items'             => __( 'All File content types', 'text-domain' ),
		'parent_item'           => __( 'Parent File content type', 'text-domain' ),
		'parent_item_colon'     => __( 'Parent File content type', 'text-domain' ),
		'edit_item'             => __( 'Edit File content type', 'text-domain' ),
		'update_item'           => __( 'Update File content type', 'text-domain' ),
		'add_new_item'          => __( 'Add New File content type', 'text-domain' ),
		'new_item_name'         => __( 'New File content type', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove File content types', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used File content types', 'text-domain' ),
		'menu_name'             => __( 'File content types', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'file-content-type', array( 'materials' ), $args );
}

add_action( 'init', 'file_content_taxonomy' );

/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function material_file_type() {

	$labels = array(
		'name'                  => _x( 'File type', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'File type', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search File types', 'text-domain' ),
		'popular_items'         => __( 'Popular File types', 'text-domain' ),
		'all_items'             => __( 'All File types', 'text-domain' ),
		'edit_item'             => __( 'Edit File type', 'text-domain' ),
		'update_item'           => __( 'Update File type', 'text-domain' ),
		'add_new_item'          => __( 'Add New File type', 'text-domain' ),
		'new_item_name'         => __( 'New File type', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove File types', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used File types', 'text-domain' ),
		'menu_name'             => __( 'File types', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'file-type', array( 'materials' ), $args );
}
add_action( 'init', 'material_file_type' );

function add_materilas_terms_types() {
	if (!term_exists( $term = 'Presentation', $taxonomy = 'file-type', $parent = null )) {
		wp_insert_term( $term = 'Presentation', $taxonomy = 'file-type');
	}	
	if (!term_exists( $term = 'Document', $taxonomy = 'file-type', $parent = null )) {
		wp_insert_term( $term = 'Document', $taxonomy = 'file-type');
	}
	if (!term_exists( $term = 'Video', $taxonomy = 'file-type', $parent = null )) {
		wp_insert_term( $term = 'Video', $taxonomy = 'file-type');
	}
	if (!term_exists( $term = 'Image', $taxonomy = 'file-type', $parent = null )) {
		wp_insert_term( $term = 'Image', $taxonomy = 'file-type');
	}
	if (!term_exists( $term = 'Voice', $taxonomy = 'file-type', $parent = null )) {
		wp_insert_term( $term = 'Voice', $taxonomy = 'file-type');
	}
}
add_action( 'init', 'add_materilas_terms_types' );

/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function target_group_taxonomy() {

	$labels = array(
		'name'                  => _x( 'Target groups', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Target group', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search Target groups', 'text-domain' ),
		'popular_items'         => __( 'Popular Target groups', 'text-domain' ),
		'all_items'             => __( 'All Target groups', 'text-domain' ),
		'edit_item'             => __( 'Edit Target group', 'text-domain' ),
		'update_item'           => __( 'Update Target group', 'text-domain' ),
		'add_new_item'          => __( 'Add Target group', 'text-domain' ),
		'new_item_name'         => __( 'New Target group', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove Target groups', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used Target groups', 'text-domain' ),
		'menu_name'             => __( 'Target groups', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'target-group', array( 'materials' ), $args );
}

add_action( 'init', 'target_group_taxonomy' );

/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function fm_material_author_taxonomy() {

	$labels = array(
		'name'                  => _x( 'Material authors', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Material author', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search Material authors', 'text-domain' ),
		'popular_items'         => __( 'Popular Material authors', 'text-domain' ),
		'all_items'             => __( 'All Material authors', 'text-domain' ),
		'edit_item'             => __( 'Edit Material author', 'text-domain' ),
		'update_item'           => __( 'Update Material author', 'text-domain' ),
		'add_new_item'          => __( 'Add New Material author', 'text-domain' ),
		'new_item_name'         => __( 'New Material author', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove Material authors', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used Material authors', 'text-domain' ),
		'menu_name'             => __( 'Material authors', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'material-author', array( 'materials' ), $args );
}

add_action( 'init', 'fm_material_author_taxonomy' );

/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function fm_institution_taxonomy() {

	$labels = array(
		'name'                  => _x( 'Institutions', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Institution', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search Institutions', 'text-domain' ),
		'popular_items'         => __( 'Popular Institutions', 'text-domain' ),
		'all_items'             => __( 'All Institutions', 'text-domain' ),
		'edit_item'             => __( 'Edit Institution', 'text-domain' ),
		'update_item'           => __( 'Update Institution', 'text-domain' ),
		'add_new_item'          => __( 'Add New Institution', 'text-domain' ),
		'new_item_name'         => __( 'New Institution', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove Institutions', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used Institutions', 'text-domain' ),
		'menu_name'             => __( 'Institutions', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'institution', array( 'materials' ), $args );
}
add_action( 'init', 'fm_institution_taxonomy' );

function fm_recommended_taxonomy() {
	$labels = array(
		'name'                  => _x( 'Recommendes', 'Taxonomy plural name', 'text-domain' ),
		'singular_name'         => _x( 'Recommended', 'Taxonomy singular name', 'text-domain' ),
		'search_items'          => __( 'Search Recommendes', 'text-domain' ),
		'popular_items'         => __( 'Popular Recommendes', 'text-domain' ),
		'all_items'             => __( 'All Recommendes', 'text-domain' ),
		'edit_item'             => __( 'Edit Recommended', 'text-domain' ),
		'update_item'           => __( 'Update Recommended', 'text-domain' ),
		'add_new_item'          => __( 'Add New Recommended', 'text-domain' ),
		'new_item_name'         => __( 'New Recommended', 'text-domain' ),
		'add_or_remove_items'   => __( 'Add or remove Recommendes', 'text-domain' ),
		'choose_from_most_used' => __( 'Choose from most used Recommendes', 'text-domain' ),
		'menu_name'             => __( 'Recommendes', 'text-domain' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'recommended', array( 'materials' ), $args );
}
add_action( 'init', 'fm_recommended_taxonomy' );
?>