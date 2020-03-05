<?php
function GTU_L_Geolocate_JS_Init() { wp_enqueue_script('gtu_l_geolocate', plugin_dir_url(__FILE__) . 'gtu_l_geolocate.js'); } add_action( 'wp_enqueue_scripts', 'GTU_L_Geolocate_JS_Init', 0 );
function GTU_L_AllZips() { wp_enqueue_script('gtu_l_allzips', plugin_dir_url(__FILE__) . 'gtu_l_allzips.js'); } add_action( 'wp_print_footer_scripts', 'GTU_L_AllZips', 0 );



function GTU_L_Geolocate() {
	echo '<script>GTU_L_Geolocate();</script>';
} add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate', 0 );
function GTU_L_Geolocate_Local() {
	echo '<script>setTimeout(function() {if(GTU_L.Posts[0].distance) {var DistanceAway = document.getElementById("DistanceAway"); if(DistanceAway) {DistanceAway.innerHTML = (Math.round(Stores[0].distance * 10, 5))/10+ " Miles away!";}}}, 500);</script>';
} add_action( 'wp_print_footer_scripts', 'GTU_L_Geolocate_Local', 0 );

?>