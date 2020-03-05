<?php

function GTU_L_Tools_JS_Init() { wp_enqueue_script('gtu_l_tools', plugin_dir_url(__FILE__) . 'gtu_l_tools.js'); } add_action( 'wp_enqueue_scripts', 'GTU_L_Tools_JS_Init', 0 );

//function GTU_L_FormAutofillLocation_Init() { echo '<script>GTU_L_FormAutofillLocation(29);</script>'; } add_action( 'wp_footer', 'GTU_L_FormAutofillLocation_Init', 0 );

if(!function_exists('Test')) { // PHP script to dump variable into JavaScript console on front-end.
	function Test($output, $with_script_tags = false) {
		$js_code = json_encode($output, JSON_HEX_TAG);
		if ($with_script_tags===false) { echo '<script>console.log("GTU Test: " + ' .json_encode($js_code). ');</script>'; }
		else { echo "<pre>" .var_dump($js_code). "</pre>"; }
	 }
}
function GTU_L_GetSubdomain_ID() { // Gets the Post ID (by post title) of the currently active location.
	if($GLOBALS['GTU_L']->Local) {
		$Location = $GLOBALS['GTU_L']->Local->post_name;
		$Posts = get_posts(array('post_type' => get_site_option('GTU_L_Settings_Lower'), 'numberposts' => 999));

		foreach($Posts as $Post) {
			if($Post->post_name == $GLOBALS['GTU_L']->Local->post_name) {
				return $Post->ID;
			}
		}
	}
}

function GTU_L_FormatHours($InputHours) { // returns cosmetic AM/PM string based on military time in text format.
	$Hours = explode(':',$InputHours);
	if($Hours[0] > 12) { $Hours[0] -= 12; $Hours = implode(':',$Hours) . 'pm'; }
	elseif($Hours[0] == 12) { $Hours = implode(':',$Hours) . 'pm'; }
	elseif($Hours[0] == 0) { $Hours[0] = 12; $Hours = implode(':',$Hours) . 'am'; }
	else { $Hours = implode(':',$Hours) . 'am'; }
	
	return $Hours;
}
function GTU_L_FormatPhone($InputPhone) { // If string contains any letters, display exact string. If not, format (xxx)xxx-xxxx
	if(strlen($InputPhone) == strlen($InputPhone *1)) { return ('(' .substr($InputPhone,0,3). ') ' .substr($InputPhone,3,3). '-' .substr($InputPhone,6,4)); }
	else { return $InputPhone; }
}
function GTU_L_DisplayPhoneLink($FieldName='phone',$DisplayText=['',''],$Classes='') { // Prints Phone Buttons button using Location's "Address Phone" link.
	$IconClass = get_site_option('GTU_L_Settings_PhoneIcon');
	$Phone = get_field($FieldName,GTU_L_GetSubdomain_ID());
	echo ('<a href="tel:'. $Phone .'" class="'.$Classes.'"><i class="'.$IconClass.'"></i> '.$DisplayText[0].' '. GTU_L_FormatPhone($Phone) .' '. $DisplayText[1].'</a>');
}

?>