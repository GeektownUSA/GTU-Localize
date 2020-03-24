<?php
//function GTU_L_JQuery_ForceLoad() { // ACF.js relies on jQuery, which doesn't always laod in time. This forces it to load early.
//	wp_enqueue_script('gtu_l_jquery', 'https://'.$_SERVER['HTTP_HOST'].'/wp-includes/js/jquery/jquery.js');
//	wp_enqueue_script('gtu_l_jquery-migrate', 'https://'.$_SERVER['HTTP_HOST'].'/wp-includes/js/jquery/jquery-migrate.min.js');
//} add_action( 'wp_enqueue_scripts', 'GTU_L_JQuery_ForceLoad' );

function GTU_L_Locations_JS() {
	// Register the script
	wp_register_script( 'GTU_L_Locations_JS', '' );

	// Localize the script with new data
	$Posts = get_posts(array('post_type' => get_site_option('GTU_L_Settings_Lower'), 'numberposts' => 999));
	foreach($Posts as $Post) { //  Send ACF values to JS.
		$ACF = get_fields($Post->ID);
		$ThisObj = new stdClass();
		if($ACF) {
			foreach($ACF as $Key => $Val) { $ThisObj->$Key = $Val; }
			$Post->ACF = $ThisObj;
		}
	}
	wp_localize_script( 'GTU_L_Locations_JS', 'GTU_L_Locations', $Posts );

	// Enqueued script with localized data.
	wp_enqueue_script( 'GTU_L_Locations_JS' );
	
} add_action( 'wp_enqueue_scripts', 'GTU_L_Locations_JS' );

function GTU_L_Geolocate_JS_Init() { wp_enqueue_script('gtu_l_geolocate', plugin_dir_url(__FILE__) . 'gtu_l_geolocate.js', array('jquery'), null, true); } add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate_JS_Init', 0 );
function GTU_L_Geolocate() { if(!$GLOBALS['GTU_L']->Local) { echo '<script>GTU_L_Geolocate();</script>'; } } add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate' );



//								    wp_enqueue_script('my-custom-script', get_template_directory_uri() .'/js/my-custom-script.js', array('jquery'), null, true);
//function GTU_L_Geolocate() {
//	echo '<script>GTU_L_Geolocate();</script>';
//} add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate', 0 );

//function GTU_L_AllZips() { wp_enqueue_script('gtu_l_allzips', plugin_dir_url(__FILE__) . 'gtu_l_allzips.js'); } add_action( 'wp_print_footer_scripts', 'GTU_L_AllZips', 0 );
//function GTU_L_Geolocate_Local() {
//	echo '<script>setTimeout(function() {if(GTU_L.Posts[0].distance) {var DistanceAway = document.getElementById("DistanceAway"); if(DistanceAway) {DistanceAway.innerHTML = (Math.round(Stores[0].distance * 10, 5))/10+ " Miles away!";}}}, 500);</script>';
//} add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate_Local', 0 );

?>