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

add_action( 'add_meta_boxes', 'make_site_add_meta_box' );
function make_site_add_meta_box() {
	add_meta_box( 'make_site_properties', 'Site Properties', 'make_site_properties_cb', 'make_site', 'advanced', 'core' );
}

function make_site_properties_cb( $post ) {
	wp_nonce_field( 'make_site_nonce', 'make_site_nonce' );
	$weekly_meeting       = get_post_meta( $post->ID, 'weekly_meeting', true );
	$weekly_meeting_when  = get_post_meta( $post->ID, 'weekly_meeting_when', true );
	$weekly_meeting_where = get_post_meta( $post->ID, 'weekly_meeting_where', true );
	?>
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="weekly_meeting"><?php esc_html_e( 'Weekly Meeting', 'make-wporg' ); ?></label></th>
				<td><input type="checkbox" id="weekly_meeting" name="weekly_meeting" value="1" <?php checked( $weekly_meeting, '1' ); ?> /></td>
			</tr>
			<tr>
				<th><label style="margin-left:2em;" for="weekly_meeting_when"><?php esc_html_e( 'When?', 'make-wporg' ); ?></label></th>
				<td><input class="widefat" type="text" id="weekly_meeting_when" name="weekly_meeting_when" placeholder="Wednesdays @ 20:00 UTC" value="<?php echo esc_attr( $weekly_meeting_when ); ?>" /></td>
			</tr>
			<tr>
				<th><label style="margin-left:2em;" for="weekly_meeting_where"><?php esc_html_e( 'Where?', 'make-wporg' ); ?></label></th>
				<td><input class="widefat" type="text" id="weekly_meeting_where" name="weekly_meeting_where" placeholder="#wordpress-dev on irc.freenode.net" value="<?php echo esc_attr( $weekly_meeting_where ); ?>" /></td>
			</tr>
		</tbody>
	</table>
	<?php
}

add_action( 'save_post', 'make_site_save_postdata' );
function make_site_save_postdata( $post_id ) {

	if ( 'make_site' != $_REQUEST['post_type'] ) {
		return;
	}

	if ( ! isset( $_POST['make_site_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['make_site_nonce'], 'make_site_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}


	$weekly_meeting = empty( $_POST['weekly_meeting'] ) ? '' : '1';
	$weekly_meeting_when = sanitize_text_field( $_POST['weekly_meeting_when'] );
	$weekly_meeting_where = sanitize_text_field( $_POST['weekly_meeting_where'] );

	update_post_meta( $post_id, 'weekly_meeting', $weekly_meeting );
	update_post_meta( $post_id, 'weekly_meeting_when', $weekly_meeting_when );
	update_post_meta( $post_id, 'weekly_meeting_where', $weekly_meeting_where );
}
