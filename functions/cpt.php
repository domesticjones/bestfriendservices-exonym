<?php
/*
===========================
  [[[ Custom Post Types ]]]
===========================
*/

// Clear Rewrite Rules for CPT's
function ex_theme_terlet() {
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'ex_theme_terlet');

function cpt_faq() {
	$labels = array(
		'name'                  => _x( 'FAQ', 'Post Type General Name', 'faq' ),
		'singular_name'         => _x( 'Question', 'Post Type Singular Name', 'faq' ),
		'menu_name'             => __( 'FAQ', 'faq' ),
		'name_admin_bar'        => __( 'Question', 'faq' ),
		'archives'              => __( 'FAQ Archives', 'faq' ),
		'attributes'            => __( 'Question Attributes', 'faq' ),
		'parent_item_colon'     => __( 'Parent Question:', 'faq' ),
		'all_items'             => __( 'All Questions', 'faq' ),
		'add_new_item'          => __( 'Add New Question', 'faq' ),
		'add_new'               => __( 'Add New', 'faq' ),
		'new_item'              => __( 'New Question', 'faq' ),
		'edit_item'             => __( 'Edit Question', 'faq' ),
		'update_item'           => __( 'Update Question', 'faq' ),
		'view_item'             => __( 'View Question', 'faq' ),
		'view_items'            => __( 'View Questions', 'faq' ),
		'search_items'          => __( 'Search Question', 'faq' ),
		'not_found'             => __( 'Not found', 'faq' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'faq' ),
		'featured_image'        => __( 'Featured Image', 'faq' ),
		'set_featured_image'    => __( 'Set featured image', 'faq' ),
		'remove_featured_image' => __( 'Remove featured image', 'faq' ),
		'use_featured_image'    => __( 'Use as featured image', 'faq' ),
		'insert_into_item'      => __( 'Insert into Question', 'faq' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Question', 'faq' ),
		'items_list'            => __( 'FAQ list', 'faq' ),
		'items_list_navigation' => __( 'FAQ list navigation', 'faq' ),
		'filter_items_list'     => __( 'Filter FAQ list', 'faq' ),
	);
	$args = array(
		'label'                 => __( 'Question', 'faq' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-chat',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'faq', $args );
}
add_action( 'init', 'cpt_faq', 0 );

function cpt_resources() {
	$labels = array(
		'name'                  => _x( 'Resources', 'Post Type General Name', 'resources' ),
		'singular_name'         => _x( 'Resource', 'Post Type Singular Name', 'resources' ),
		'menu_name'             => __( 'Resources', 'resources' ),
		'name_admin_bar'        => __( 'Resource', 'resources' ),
		'archives'              => __( 'Resource Archives', 'resources' ),
		'attributes'            => __( 'Resource Attributes', 'resources' ),
		'parent_item_colon'     => __( 'Parent Resource:', 'resources' ),
		'all_items'             => __( 'All Resources', 'resources' ),
		'add_new_item'          => __( 'Add New Resource', 'resources' ),
		'add_new'               => __( 'Add New', 'resources' ),
		'new_item'              => __( 'New Resource', 'resources' ),
		'edit_item'             => __( 'Edit Resource', 'resources' ),
		'update_item'           => __( 'Update Resource', 'resources' ),
		'view_item'             => __( 'View Resource', 'resources' ),
		'view_items'            => __( 'View Resources', 'resources' ),
		'search_items'          => __( 'Search Resource', 'resources' ),
		'not_found'             => __( 'Not found', 'resources' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'resources' ),
		'featured_image'        => __( 'Featured Image', 'resources' ),
		'set_featured_image'    => __( 'Set featured image', 'resources' ),
		'remove_featured_image' => __( 'Remove featured image', 'resources' ),
		'use_featured_image'    => __( 'Use as featured image', 'resources' ),
		'insert_into_item'      => __( 'Insert into Resource', 'resources' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Resource', 'resources' ),
		'items_list'            => __( 'Resources list', 'resources' ),
		'items_list_navigation' => __( 'Resources list navigation', 'resources' ),
		'filter_items_list'     => __( 'Filter Resources list', 'resources' ),
	);
	$args = array(
		'label'                 => __( 'Resource', 'resources' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'help-center',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'resource', $args );
}
add_action( 'init', 'cpt_resources', 0 );

// Change "Enter Title Here" text on CPT's
function ex_change_title_text($title) {
  $screen = get_current_screen();
  if('faq' == $screen->post_type ) {
    $title = 'Enter the question here';
  } elseif('resource' == $screen->post_type ) {
    $title = 'Enter the resource topic here';
  }
  return $title;
}
add_filter('enter_title_here', 'ex_change_title_text');

// Redirect archives to parents
function ex_redirect_cpt_archive() {
  if(is_singular('faq')) {
    wp_redirect(get_post_type_archive_link('faq'), 301);
    exit();
  }
}
add_action('template_redirect', 'ex_redirect_cpt_archive');

// List all archives on CPT
function ex_listall_posts_archive( $query ) {
  if($query->is_main_query() && !is_admin() ) {
    if(is_post_type_archive('faq')) {
      $query->set('posts_per_page', -1);
    }
  }
}
add_action('pre_get_posts', 'ex_listall_posts_archive');
