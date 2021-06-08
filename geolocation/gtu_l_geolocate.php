<?php

function GTU_L_Locations_JS()
{
	// Register the script
	wp_register_script('GTU_L_Locations_JS', '');

	// Localize the script with new data

	$post_type = get_site_option('GTU_L_Settings_Lower');
	$posts = is_main_site() && get_gtu_field('location_posts') ? get_gtu_field('location_posts') : get_posts(array('post_type' => $post_type, 'numberposts' => -1));

	foreach ($posts as $post) { //  Send ACF values to JS.
		$acf = new stdClass();
		$gtu_geo_field_keys = explode(',', get_site_option('GTU_L_Settings_Geolocation_Fields'));

		foreach ($gtu_geo_field_keys as $value) {
			$acf->{$value} = get_field($value, $post->ID);
		}

		$acf->longitude = get_field('longitude', $post->ID);
		$acf->latitude = get_field('latitude', $post->ID);

		if ($acf) {
			$post->ACF = $acf;
		}
	}

	wp_localize_script('GTU_L_Locations_JS', 'GTU_L_Locations', $posts);

	// Enqueued script with localized data.
	wp_enqueue_script('GTU_L_Locations_JS');
}

add_action('wp_enqueue_scripts', 'GTU_L_Locations_JS');

function GTU_L_Geolocate_JS_Init()
{
	wp_enqueue_script('gtu_l_geolocate', plugin_dir_url(__FILE__) . 'gtu_l_geolocate.js', array('jquery'), null, true);
}
add_action('wp_print_footer_scripts', 'GTU_L_Geolocate_JS_Init', 0);

function GTU_L_Geolocate()
{
	if (!$GLOBALS['GTU_L']->Local) {
		echo '<script>GTU_L_Geolocate();</script>';
	}
}
add_action('wp_print_footer_scripts', 'GTU_L_Geolocate');
