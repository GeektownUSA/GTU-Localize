<?php
/**
 * Plugin Name: GTU Localize
 * Plugin URI: https://www.geektownusa.com/gtu-localize
 * Description: Creates a Location structure for Corporations, stores local/corporate information for use in the front-end.
 * Version: 0.3
 * Author: Geek Town USA
 * Author URI: https://www.geektownusa.com
 */

//$GLOBALS['GTU_L'] = new stdClass();
$Debug = false;

// Settings //
function GTU_L_Network_Settings_Menu() {
	add_submenu_page('settings.php','Localization Settings','Localization Settings','manage_network_options','gtu-l-settings','GTU_L_Network_Settings_Page');
} add_action('network_admin_menu', 'GTU_L_Network_Settings_Menu');
function GTU_L_Network_Settings_Page(){ include_once('pages/settings.php'); }
function GTU_L_Update_Settings(){
 	check_admin_referer('_GTU_L_Settings_Nonce');
	if(!current_user_can('manage_network_options')) wp_die('FU');

	update_site_option('GTU_L_Settings_Display',$_POST['GTU_L_Settings_Display']);
	update_site_option('GTU_L_Settings_Lower',sanitize_title($_POST['GTU_L_Settings_Display']));
	update_site_option('GTU_L_Settings_Icon',$_POST['GTU_L_Settings_Icon']);
	
	update_site_option('GTU_L_Settings_Corporate',$_POST['GTU_L_Settings_Corporate']);

	update_site_option('GTU_L_Settings_PhoneIcon',$_POST['GTU_L_Settings_PhoneIcon']);
	
	{ // Geolocation Settings
		if(isset($_POST['GTU_L_Settings_Geolocation'])) { update_site_option('GTU_L_Settings_Geolocation',true); }
		else { update_site_option('GTU_L_Settings_Geolocation',false); }

		update_site_option('GTU_L_Settings_Geolocation_Prefix',$_POST['GTU_L_Settings_Geolocation_Prefix']);
		update_site_option('GTU_L_Settings_Geolocation_Fields',$_POST['GTU_L_Settings_Geolocation_Fields']);
		if(isset($_POST['GTU_L_Settings_Geolocation_Localize_HREFs'])) { update_site_option('GTU_L_Settings_Geolocation_Localize_HREFs',true); }
		else { update_site_option('GTU_L_Settings_Geolocation_Localize_HREFs',false); }
		
		update_site_option('GTU_L_Settings_Geolocation_Scripts',$_POST['GTU_L_Settings_Geolocation_Scripts']);
	}
	
	{ // Social Settings
		if(isset($_POST['GTU_L_Settings_Social_Facebook'])) { update_site_option('GTU_L_Settings_Social_Facebook',true); }
		else { update_site_option('GTU_L_Settings_Social_Facebook',false); }

		if(isset($_POST['GTU_L_Settings_Social_Instagram'])) { update_site_option('GTU_L_Settings_Social_Instagram',true); }
		else { update_site_option('GTU_L_Settings_Social_Instagram',false); }

		if(isset($_POST['GTU_L_Settings_Social_Youtube'])) { update_site_option('GTU_L_Settings_Social_Youtube',true); }
		else { update_site_option('GTU_L_Settings_Social_Youtube',false); }

		if(isset($_POST['GTU_L_Settings_Social_Pinterest'])) { update_site_option('GTU_L_Settings_Social_Pinterest',true); }
		else { update_site_option('GTU_L_Settings_Social_Pinterest',false); }

	}
	
	{ // SEO Settings
		if(isset($_POST['GTU_L_Settings_SEO_DisplaySchema'])) { update_site_option('GTU_L_Settings_SEO_DisplaySchema',true); }
		else { update_site_option('GTU_L_Settings_SEO_DisplaySchema',false); }
		update_site_option('GTU_L_Settings_SEO_Icon',$_POST['GTU_L_Settings_SEO_Icon']);
	}
	
	{ // SLP Settings
		if(isset($_POST['GTU_L_Settings_SLP'])) { update_site_option('GTU_L_Settings_SLP',true); }
		else { update_site_option('GTU_L_Settings_SLP',false); }
	}
	
	wp_redirect(admin_url('network/settings.php?page=gtu-l-settings'));
	exit;  
} add_action('admin_post_update_my_settings',  'GTU_L_Update_Settings');


function GTU_L_Location_Post_Type() {
	if(get_site_option('GTU_L_Settings_Display')) {
		$Display = get_site_option('GTU_L_Settings_Display');
		$Displays = $Display . 's';
		$Lower = get_site_option('GTU_L_Settings_Lower');
		$Lowers = $Lower . 's';
		$Icon = get_site_option('GTU_L_Settings_Icon');
		$GLOBALS['GTU_L'] = new stdClass();

		$labels = array(
			'name'                  => _x( $Displays, 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( $Display, 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( $Displays, 'text_domain' ),
			'name_admin_bar'        => __( $Display, 'text_domain' ),
			'archives'              => __( $Display. ' List', 'text_domain' ),
			'attributes'            => __( 'Item Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All '. $Displays, 'text_domain' ),
			'add_new_item'          => __( 'Add New ' .$Displays, 'text_domain' ),
			'add_new'               => __( 'Add ' .$Display, 'text_domain' ),
			'new_item'              => __( 'New ' .$Display, 'text_domain' ),
			'edit_item'             => __( 'Edit ' .$Display, 'text_domain' ),
			'update_item'           => __( 'Update ' .$Display, 'text_domain' ),
			'view_item'             => __( 'View ' .$Display, 'text_domain' ),
			'view_items'            => __( 'View ' .$Displays, 'text_domain' ),
			'search_items'          => __( 'Search ' .$Display, 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( $Display. ' Photo', 'text_domain' ),
			'set_featured_image'    => __( 'Set '.$Lower.' photo', 'text_domain' ),
			'remove_featured_image' => __( 'Remove '.$Lower.' photo', 'text_domain' ),
			'use_featured_image'    => __( 'Use as '.$Lower.' photo', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into '.$Lower, 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this '.$Lower, 'text_domain' ),
			'items_list'            => __( $Display. ' list', 'text_domain' ),
			'items_list_navigation' => __( $Display. ' list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter '.$Lower.' list', 'text_domain' ),
		);
		$rewrite = array(
			'slug'                  => $Lowers,
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( $Display, 'text_domain' ),
			'description'           => __( $Display.' Profiles', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 2,
			'menu_icon'             => $Icon,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
		);
		register_post_type( $Lower, $args );
		
		include_once('gtu_acf.php');
	} else {
		function GTU_L_Location_Post_Type_ERROR() {
		// Return an error if Settings has not been initialized after install.
			?>
			<div class="notice notice-success is-dismissible">
				<p>GTU_Localize will not work until it is configured in <a href="network/settings.php?page=gtu-l-settings">Network Settings</a>.</p>
			</div>
			<?php
		} add_action( 'admin_notices', 'GTU_L_Location_Post_Type_ERROR', 0 );
	}

	if(is_main_site() && !is_admin()) {
		do_action('gtu/load_posts');
	}
	
} add_action( 'init', 'GTU_L_Location_Post_Type', 0 );
function GTU_L_DetectLocation() { // This does most of the work for this plugin.
	$GLOBALS['GTU_L']->Local = '';

	$post= get_subdomain_post();
	
	if(is_main_site()) {
		$GLOBALS['GTU_L']->Corporate = $post;
	} else {
		$GLOBALS['GTU_L']->Local = $post;
	}

		
} add_action( 'get_header', 'GTU_L_DetectLocation', 0 );

// Not sure if this works correctly. The idea was to make the plugin host it's own local template, then make it work by default. This is taking too long, so I'm doing it the 0.2.1 way.
//function GTU_L_Location_Template($single) { /* Filter the single_template with our custom function*/
//    global $post;
//
//    /* Checks for single template by post type */
//    if ( $post->post_type == sanitize_title(get_site_option('GTU_L_Settings_Display'))) {
//		if ( file_exists(plugin_dir_path( __FILE__ ) . 'pages/location.php' ) ) {
//            return plugin_dir_path( __FILE__ ) . 'pages/location.php';
//        }
//    }
//
//    return $single;
//} add_filter('single_template', 'GTU_L_Location_Template');

function GTU_L_SLP() { if(get_site_option('GTU_L_Settings_SLP')) { include_once('slp/gtu_slp.php'); } } add_action( 'init', 'GTU_L_SLP', 0 );
function GTU_L_Geolocation_Init() { if(get_site_option('GTU_L_Settings_Geolocation')) { include_once('geolocation/gtu_l_geolocate.php'); } } add_action( 'init', 'GTU_L_Geolocation_Init', 0 );
function GTU_L_Tools() { include_once('tools/gtu_l_tools.php'); } add_action( 'after_setup_theme', 'GTU_L_Tools', 0 );

//$Debug = true;
function GTU_L_Dump($Debug) { if($Debug==true) { foreach($GLOBALS['GTU_L'] as $Item) { Test_L($Item); } } } add_action( 'wp_enqueue_scripts', 'GTU_L_Dump', 0 );