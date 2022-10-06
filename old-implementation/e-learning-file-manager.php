<?php
/*
Plugin Name: E-learning file manager
Description: Plugin for file managering on web sites
Version: 1.0
Author: Leoš Lang
License: GPLv2
*/

include (plugin_dir_path( __FILE__ ).'inc/register-material-post.php');
include (plugin_dir_path( __FILE__ ).'inc/register-taxonomy.php');
include (plugin_dir_path( __FILE__ ).'inc/admin/material-edit-page.php');
include (plugin_dir_path( __FILE__ ).'inc/admin/admin-setting-pages.php');
include (plugin_dir_path( __FILE__ ).'inc/ajax/materials-autosuggest.php');


register_activation_hook( __FILE__, 'fm_install' );
function fm_install(){
    if (get_option('ll_main_page_id', '00') == '00') {
        add_option('ll_main_page_id', '00');
    }

    if (get_option('ll_is_top_materials_allow',true)) {
       add_option('ll_is_top_materials_allow',true);
    }

    if( get_option('ll_top_materials_count', '5') == '5') {
        add_option('ll_top_materials_count', '5');
    }  

    if(get_option('ll_is_newest_materials_allow', true)) {
        add_option('ll_is_newest_materials_allow', true);
    }  

    if(get_option('ll_new_materials_count', '5') == '5') {
        add_option('ll_new_materials_count', '5');
    }

    if(!get_option('ll_recaptcha_allow', false)) {
        add_option('ll_recaptcha_allow', false);
    }

    if(get_option('ll_recaptcha_sitekey', '') == '') {
        add_option('ll_recaptcha_sitekey', '');
    }

    if(get_option('ll_recaptcha_secretkey', '') == '') {
        add_option('ll_recaptcha_secretkey', '');
    }
}


register_deactivation_hook( __FILE__, 'fm_deactivated') ;
function fm_deactivated() {
}

add_action( 'admin_enqueue_scripts', 'fm_register_admin_scripts' );
function fm_register_admin_scripts() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_register_script( 'admin-script', plugins_url( '/js/admin.js', __FILE__ ), array('jquery','wp-color-picker') );
    wp_enqueue_script( 'admin-script' );
     wp_register_style( 'admin-css', plugins_url( '/css/admin.css', __FILE__ ));
    wp_enqueue_style( 'admin-css' );
}

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'fm_register_user_scripts');
function fm_register_user_scripts() {
    wp_register_script( 'front-script', plugins_url( '/js/front.js', __FILE__ ), array('jquery') );
    wp_enqueue_script( 'front-script' );
    wp_register_script('recaptcha', "https://www.google.com/recaptcha/api.js", false, null);
    wp_enqueue_script('recaptcha');
    
    wp_register_style( 'front-css', plugins_url( '/css/front.css', __FILE__ ));
    wp_enqueue_style( 'front-css' );
}

add_action('wp_head', 'll_custom_css_option');
function ll_custom_css_option(){
    require_once( dirname( __FILE__ ) . '/css/custom-styles.php' );
}

add_filter( 'page_template', 'fm_page_template' );
function fm_page_template( $page_template )
{	
    $material_page_id = get_option('ll_main_page_id',$the_page_id);
    if (is_page($material_page_id)) {
        $page_template = dirname( __FILE__ ) . '/inc/templates/materials-page.php';    
    }
    return $page_template;
}

add_filter('archive_template', 'yourplugin_get_custom_archive_template');
function yourplugin_get_custom_archive_template($template) {
    global $wp_query;
    if (is_post_type_archive('materials')) {
        $page_template = dirname( __FILE__ ) . '/inc/templates/materials-page.php';    
    }
    return $page_template;
}


add_filter('single_template', 'fm_single_material_template');
function fm_single_material_template($single) {
    global $wp_query, $post;
    if ( $post->post_type == 'materials' ) {
        $single = dirname( __FILE__ ) . '/inc/templates/single-material.php';
    }
    return $single;
}


function truncate($text, $chars = 25) {
    if (strlen($text) <= $chars) {
        return $text;
    }
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."...";
    return $text;
}


function ll_set_post_view($postID) {
    $views = get_post_meta($postID,'post_views', true);
    if ($views == "") {
        $views = 1;
        add_post_meta( $postID, 'post_views', $views, $unique = false );
    }else {
        $views = $views+1;
        update_post_meta( $postID, 'post_views', $views, $prev_value = '' );
    }
}


function ll_get_post_views($postID) {
    $views = get_post_meta($postID,'post_views', true);
    if ($views=="") {
        return 0;
    }else {
        return $views;
    }
}


function ww_load_dashicons(){
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'ww_load_dashicons');


add_filter( 'posts_where', 'fm_custom_search_title', 10, 2 );
function fm_custom_search_title( $where, &$wp_query ) {
    global $wpdb;
    if ( $customSearchTitle = $wp_query->get( 'customSearchTitle' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $customSearchTitle ) ) . '%\'';
    }
    return $where;
}

function fm_get_dashicon_from_mime_type($type) {
    if ($type == 'application/pdf' ) {
        return '<span class="dashicons dashicons-media-document"></span>';
    }elseif ($type == 'application/msword' || $type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' 
|| $type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $type == 'application/vnd.oasis.opendocument.text') {
        return '<span class="dashicons dashicons-media-document"></span>';
    }elseif ($type == 'application/mspowerpoint' || $type=='application/powerpoint' || $type == 'application/vnd.ms-powerpoint' || $type == 'application/x-mspowerpoint' || $type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $type== 'application/mspowerpoint' || $type=='application/vnd.ms-powerpoint' || $type ==' application/vnd.openxmlformats-officedocument.presentationml.slideshow' || $type == 'application/vnd.oasis.opendocument.presentation') {
        return '<span class="dashicons dashicons-media-interactive"></span>';
    }elseif ($type== 'application/excel' || $type == 'application/vnd.ms-excel' || $type == 'application/x-excel' || $type == 'application/x-msexcel' || $type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $type == 'application/vnd.oasis.opendocument.spreadsheet') {
        return '<span class="dashicons dashicons-media-spreadsheet"></span>';
    }elseif ($type == 'audio/mpeg3' || $type == 'audio/x-mpeg-3' || $type == 'video/mpeg' || $type == 'video/x-mpeg' || $type == 'audio/m4a' || $type == 'audio/ogg' || $type == 'audio/wav' || $type == 'audio/x-wav') {
        return '<span class="dashicons dashicons-media-audio"></span>';
    }elseif ($type == 'video/mp4' || $type == 'video/x-m4v' || $type == 'video/quicktime' || $type == 'video/x-ms-asf' || $type = 'video/x-ms-wmv' || $type == 'application/x-troff-msvideo' || $type == 'video/avi' || $type == 'video/msvideo' || $type == 'video/x-msvideo' || $type == 'video/ogg' || $type == 'video/x-matroska') {
       return '<span class="dashicons dashicons-media-video"></span>';
    }elseif ($type == 'application/x-tar' || $type == 'application/zip' || $type == 'application/x-zip' || $type == 'application/x-zip' || $type == 'application/rar' || $type == 'application/x-7z-compressed') {
       return '<span class="dashicons dashicons-media-archive"></span>';
    }else {
     return '<span class="dashicons dashicons-media-default"></span>';
    }
}

function fm_count_avgRate($material_id) {
        $args = array(
            'post_id' => $material_id,
            'meta_key' => 'stars',
            'meta_query' => array(
                                array(
                                    'key'     => 'stars',
                                    'value'   => '0',
                                    'compare' => '>'
                                )
                            )
        );
        $comments =  get_comments( $args );

        $stars = 0;
        foreach ($comments as $comment) {
            $starsCount = get_comment_meta( $comment->comment_ID, $key = 'stars', $single = true );
            $stars = $stars + $starsCount;
        }

        if (sizeof($comments) > 0) {
            # code...
            return $stars/sizeof($comments);
        }else {
            return 0;
        }
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('autocomplete-search', plugins_url( '/js/autocomplete.js', __FILE__ ), 
        ['jquery', 'jquery-ui-autocomplete'], null, true);
        wp_localize_script('autocomplete-search', 'AutocompleteSearch', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('autocompleteSearchNonce')
        ]);

        $wp_scripts = wp_scripts();
        wp_enqueue_style('jquery-ui-css',
            '//ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-autocomplete']->ver . '/themes/smoothness/jquery-ui.css',
            false, null, false
        );
});

add_action('wp_ajax_nopriv_autocompleteSearch', 'awp_autocomplete_search');
add_action('wp_ajax_autocompleteSearch', 'awp_autocomplete_search');

?>