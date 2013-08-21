<?php

add_action( 'wp_enqueue_scripts', 'make_enqueue_scripts' );
function make_enqueue_scripts() {
	wp_enqueue_style( 'make-style', get_stylesheet_uri() );
}

add_action( 'after_setup_theme', 'make_setup_theme' );
function make_setup_theme() {
	register_nav_menu( 'primary', __( 'Navigation Menu', 'make-wporg' ) );
}

add_action( 'init', 'register_cpt_make_site' );
function register_cpt_make_site() {
	$labels = array( 
		'name'               => _x( 'Sites',                   'site', 'make-wporg' ),
		'singular_name'      => _x( 'Site',                    'site', 'make-wporg' ),
		'add_new'            => _x( 'Add New',                 'site', 'make-wporg' ),
		'add_new_item'       => _x( 'Add New Site',            'site', 'make-wporg' ),
		'edit_item'          => _x( 'Edit Site',               'site', 'make-wporg' ),
		'new_item'           => _x( 'New Site',                'site', 'make-wporg' ),
		'view_item'          => _x( 'View Site',               'site', 'make-wporg' ),
		'search_items'       => _x( 'Search Sites',            'site', 'make-wporg' ),
		'not_found'          => _x( 'No sites found',          'site', 'make-wporg' ),
		'not_found_in_trash' => _x( 'No sites found in Trash', 'site', 'make-wporg' ),
		'parent_item_colon'  => _x( 'Parent Site:',            'site', 'make-wporg' ),
		'menu_name'          => _x( 'Sites',                   'site', 'make-wporg' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => true,
		'description' => _x( 'A sub-site on the make.wordpress.org network', 'site', 'make-wporg' ),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),

		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,

		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'make_site', $args );
}

add_action( 'init', 'load_cmb' );
function load_cmb() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once( dirname(__FILE__) . '/inc/custom-meta-boxes.php' );
}

add_filter( 'cmb_meta_boxes', 'make_site_metaboxes' );
function make_site_metaboxes( $meta_boxes ) {

	$subsite_options = array(
		array(
			'name'  => __( '(select one)', 'make-wporg' ),
			'value' => '',
		),
	);

	if( function_exists( 'get_blog_list' ) ) {
		foreach( get_blog_list( 1, 'all' ) as $blog ) {
			$subsite_options[] = array(
				'name'  => $blog['domain'] . $blog['path'],
				'value' => $blog['blog_id'],
			);
		}
	} else { // Remove from production, just for development on non-network sites
		$subsite_options[] = array(
			'name'  => 'Blog One',
			'value' => 1,
		);
		$subsite_options[] = array(
			'name'  => 'Blog Two',
			'value' => 2,
		);
		$subsite_options[] = array(
			'name'  => 'Blog Three',
			'value' => 3,
		);
		$subsite_options[] = array(
			'name'  => 'Blog Four',
			'value' => 4,
		);
	}

	$meta_boxes[] = array(
		'id'         => 'make_site_data',
		'title'      => 'Site Details',
		'pages'      => array('make_site'), // post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Weekly Meeting',
				'desc' => 'Does this group have a regularly scheduled weekly meeting?',
				'id'   => 'weekly_meeting',
				'type' => 'checkbox',
			),
			array(
				'name' => 'When?',
				'desc' => 'When is the weekly meeting?',
				'id'   => 'weekly_meeting_when',
				'type' => 'text',
			),
			array(
				'name' => 'Where?',
				'desc' => 'Where is the weekly meeting?',
				'id'   => 'weekly_meeting_where',
				'type' => 'text',
			),
			array(
				'name' => 'Which blog?',
				'desc' => 'Which subsite does this entry reference?',
				'id'   => 'which_subsite',
				'type' => 'select',
				'options' => $subsite_options,
			),
		),
	);

	return $meta_boxes;
}
