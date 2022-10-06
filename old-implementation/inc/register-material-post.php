<?php 
/**
 * Registers a new post type
 * @uses $wp_post_types Inserts new post type object into the list
 *
 * @param string  Post type key, must not exceed 20 characters
 * @param array|string  See optional args description above.
 * @return object|WP_Error the registered post type object, or an error object
 */
function fm_material_postType() {

	$labels = array(
		'name'               => __( 'Materials', 'text-domain' ),
		'singular_name'      => __( 'Material', 'text-domain' ),
		'add_new'            => _x( 'Add New Material', 'text-domain', 'text-domain' ),
		'add_new_item'       => __( 'Add New Material', 'text-domain' ),
		'edit_item'          => __( 'Edit Material', 'text-domain' ),
		'new_item'           => __( 'New Material', 'text-domain' ),
		'view_item'          => __( 'View Material', 'text-domain' ),
		'search_items'       => __( 'Search Materials', 'text-domain' ),
		'not_found'          => __( 'No Materials found', 'text-domain' ),
		'not_found_in_trash' => __( 'No Materials found in Trash', 'text-domain' ),
		'menu_name'          => __( 'Materials', 'text-domain' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'Materials for e-learning',
		'taxonomies'          => array('file-content-type','material-language', 'key-words', 'file-type', 'target-group'),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-media-document',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'thumbnail',
			'comments',
			'revisions',
		),
	);

	register_post_type( 'materials', $args );
}

add_action('init', 'fm_material_postType');
?>