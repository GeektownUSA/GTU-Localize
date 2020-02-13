<?php
/**
 * Plugin Name: GTU Localize
 * Plugin URI: https://www.geektownusa.com/gtu-localize
 * Description: Creates a Location structure for Corporations, stores local/corporate information for use in the front-end.
 * Version: 0.2.0
 * Author: Geek Town USA
 * Author URI: https://www.geektownusa.com
 */

//$GLOBALS['GTU_L'] = new stdClass();
$Debug = false;

// Registered Functions //
function GTU_L_JS_Init() {
	echo '<script type="text/javascript" src="https://' .$_SERVER['HTTP_HOST']. '/wp-content/plugins/gtu-localize/gtu_l.js"></script>';
//	include_once 'gtu_l2.php';
} add_action( 'get_footer', 'GTU_L_JS_Init', 0 );
function GTU_L_Settings() {
	$Settings = new stdClass();
	$Settings->Display = 'Location';
	$Settings->Displays = $Settings->Display . 's';
	$Settings->Lower = strtolower($Settings->Display);
	$Settings->Lowers = $Settings->Lower . 's';
	$Settings->Icon = 'dashicons-store';

	$Settings->Corporate = 'corporate';

	$GLOBALS['GTU_L'] = new stdClass();
	$GLOBALS['GTU_L']->Settings = $Settings;
	
} add_action( 'init', 'GTU_L_Settings', 0 );
function GTU_L_location_post_type() {
	$Display = $GLOBALS['GTU_L']->Settings->Display;
	$Displays = $GLOBALS['GTU_L']->Settings->Displays;
	$Lower = $GLOBALS['GTU_L']->Settings->Lower;
	$Lowers = $GLOBALS['GTU_L']->Settings->Lowers;
	$Icon = $GLOBALS['GTU_L']->Settings->Icon;

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
		'supports'              => array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
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
} add_action( 'init', 'GTU_L_location_post_type', 0 );
function GTU_L_DetectLocation() { // This does most of the work for this plugin.
	$GLOBALS['GTU_L']->Local = '';
	$Root = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
	if(is_array($Root) && $Root != null) {$Root = $Root[0];}
	
	// Determine local and corporate posts
	$Posts = get_posts(array('post_type' => $GLOBALS['GTU_L']->Settings->Lower, 'numberposts' => 999));
	foreach($Posts as $Post) {
		// set Local post
		if($Post->post_name == $Root) { 
			$GLOBALS['GTU_L']->Local = $Post;

			$GLOBALS['GTU_L']->Local->Latitude = get_field('latitude', GTU_L_GetSubdomain_ID());
			$GLOBALS['GTU_L']->Local->Longitude = get_field('longitude', GTU_L_GetSubdomain_ID());
			$GLOBALS['GTU_L']->Local->BranchID = get_field('branchid', GTU_L_GetSubdomain_ID());
			$GLOBALS['GTU_L']->Local->Savvy = get_field('savvy_sliders', GTU_L_GetSubdomain_ID());
		}
		// set Corporate post
		if($Post->post_name == $GLOBALS['GTU_L']->Settings->Corporate) {
// This is the only piece of code that uses PHP Session Variables. This was removed in 0.2.1. I don't believe this is related to the non-location issue, however it's a loose end.
//			if($_SESSION && !($_SESSION['GTU_L'])) { $_SESSION['GTU_L'] = new stdClass(); }
//			else {
//				if($_SESSION && !($_SESSION['GTU_L']->Corporate)) { $_SESSION['GTU_L']->Corporate = new stdClass(); }
//				else {
//					$_SESSION['GTU_L'] = new stdClass();
//					$_SESSION['GTU_L']->Corporate = new stdClass();
//				}
//			}

			$GLOBALS['GTU_L']->Corporate = $Post;
		}
	}
	foreach($Posts as $Post) { //  Send ACF values to JS.
		$ACF = get_fields($Post->ID);
		$ThisObj = new stdClass();
		if($ACF) {
			foreach($ACF as $Key => $Val) { $ThisObj->$Key = $Val; }
			$Post->ACF = $ThisObj;
		}
	}

	// Add Featured Image to Post data (for later use in JS)
	foreach($Posts as $Post) { $Post->FeaturedImage = get_the_post_thumbnail_url($Post->ID); }	
	
	$GLOBALS['GTU_L']->Posts = $Posts; // This dumps Posts into the Global, which exposes them to JS later.
	if($GLOBALS['GTU_L']->Local === null) {$GLOBALS['GTU_L']->Local = $GLOBALS['GTU_L']->Corporate;}
	
	// Send GTU_L to JavaScript
	$Encoded = json_encode(json_encode($GLOBALS['GTU_L'], JSON_HEX_TAG));
	$SendToJS = '<script>var GTU_L = JSON.parse('.$Encoded.');</script>';
	echo $SendToJS;
} add_action( 'get_header', 'GTU_L_DetectLocation', 0 );
function GTU_L_FormAutofillLocation_Init() {
	echo '<script>GTU_L_FormAutofillLocation(29);</script>';
} add_action( 'wp_footer', 'GTU_L_FormAutofillLocation_Init', 0 );
function GTU_L_Geolocate() { echo '<script>GTU_L_Geolocate();</script>'; } add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate', 0 );
function GTU_L_Geolocate_Local() { echo '<script>setTimeout(function() {if(GTU_L.Posts[0].distance) {var DistanceAway = document.getElementById("DistanceAway"); if(DistanceAway) {DistanceAway.innerHTML = (Math.round(Stores[0].distance * 10, 5))/10+ " Miles away!";}}}, 500);</script>'; } add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate_Local', 0 );
function GTU_L_AllZips() { echo '<script src="/wp-content/plugins/gtu-localize/gtu_l_allzips.js" defer></script>'; } add_action( 'wp_print_footer_scripts', 'GTU_L_AllZips', 0 );

// Unregistered Functions //
function Test_L($output, $with_script_tags = false) {// PHP script to dump variable into JavaScript console on front-end.
	$js_code = json_encode($output, JSON_HEX_TAG);
	if ($with_script_tags===false) { echo '<script>console.log("GTU_L: " + ' .json_encode($js_code). ');</script>'; }
	else { echo "<pre>" .var_dump($js_code). "</pre>"; }
 }
function GTU_L_Dump() { foreach($GLOBALS['GTU_L'] as $Item) { Test_L($Item); } }
function GTU_L_GetSubdomain_ID() { // Gets the Post ID (by post title) of the currently active location.
	if($GLOBALS['GTU_L']->Local) {
		$Location = $GLOBALS['GTU_L']->Local->post_name;
		$Posts = get_posts(array('post_type' => $GLOBALS['GTU_L']->Settings->Lower, 'numberposts' => 999));

		foreach($Posts as $Post) {
			if($Post->post_name == $GLOBALS['GTU_L']->Local->post_name) {
				return $Post->ID;
			}
		}
	}
}
function GTU_L_FormatPhone($InputPhone) { return ('(' .substr($InputPhone,0,3). ') ' .substr($InputPhone,3,3). '-' .substr($InputPhone,6,4)); }
function GTU_L_Phone($FieldName='phone',$DisplayText=['',''],$Classes='',$IconClass='fas fa-phone') { // Prints Phone Buttons button using Location's "Address Phone" link.
	$Phone = get_field($FieldName,GTU_L_GetSubdomain_ID());
	echo ('<a href="tel:'. $Phone .'" class="'.$Classes.'"><i class="'.$IconClass.'"></i> '.$DisplayText[0].' '. GTU_L_FormatPhone($Phone) .' '. $DisplayText[1].'</a>');
}

// In-Line Code //
//$Debug = true;
if($Debug) { add_action( 'wp_enqueue_scripts', 'GTU_L_Dump', 0 ); }