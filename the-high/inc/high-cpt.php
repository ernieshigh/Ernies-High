<?php 
/***
	*
	*
	*  Create sample Custom Post types with taxonomy
	*
	*
***/

add_action('init', 'high_custom_post_type');
function high_custom_post_type() {
	
	$sample_label = array(
        'name' => 'Samples',
        'singular_name' => 'Sample',
        'add_new' => 'Add New Sample',
        'add_new_item' => 'Add New Sample',
        'edit_item' => 'Edit Sample',
        'new_item' => 'New Sample',
        'all_items' => 'All Samples',
        'view_item' => 'View Sample',
        'search_items' => 'Search Samples',
        'not_found' =>  'No Samples Found',
        'not_found_in_trash' => 'No Samples found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Samples',
    );
    register_post_type('sample',
        array(
            'labels'      => $sample_label,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
		'exclude_from_search' => false,
        'rewrite' => array('slug' => 'sample'),
        'query_var' => true,
        'menu_icon' => 'dashicons-randomize',
        'show_in_rest' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes'
			)
        )
    );
	
    // register taxonomy for sample post type
    register_taxonomy('sample-type', 'sample', array('show_in_rest' => true, 'hierarchical' => false, 'has_archive' => true, 'label' => 'Type', 'query_var' => true, 'rewrite' => array( 'slug' => 'sample-type' )));
	
}