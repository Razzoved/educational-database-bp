<?php
function awp_autocomplete_search()
{
    check_ajax_referer('autocompleteSearchNonce', 'security');
    $search_term = $_REQUEST['term'];
    if (!isset($_REQUEST['term'])) {
        echo json_encode([]);
    }
    $suggestions = [];
    $query = new WP_Query([
        's' => $search_term,
        'posts_per_page' => 15,
		'no_found_rows' => true,
        'post_type'   => 'materials',
		
    ]);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $suggestions[] = [
                'id' => get_the_ID(),
                'label' => get_the_title(),
                'link' => get_the_permalink()
            ];
        }
        wp_reset_postdata();
    }
    echo json_encode($suggestions);
    wp_die();
}
