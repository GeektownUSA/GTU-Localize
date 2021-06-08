<?php

use threewp_broadcast\ajax\json;

function GTU_L_Settings_JS()
{
    global $wpdb;

    $Settings = array();
    $GTU_L_Settings = new stdClass;

    array_push($Settings, "GTU_L_Settings_Corporate");
    array_push($Settings, "GTU_L_Settings_Geolocation");
    array_push($Settings, "GTU_L_Settings_Geolocation_Prefix");
    array_push($Settings, "GTU_L_Settings_Geolocation_Fields");
    array_push($Settings, "GTU_L_Settings_Geolocation_Localize_HREFs");
    array_push($Settings, "GTU_L_Settings_Geolocation_Scripts");
    $arr = implode( ", ", array_map(function($elem){return '"'.$elem.'"';}, $Settings));
    $row = $wpdb->get_results( $wpdb->prepare( "SELECT meta_value FROM $wpdb->sitemeta WHERE meta_key IN ('$arr') AND site_id = %d", get_current_network_id() ) );
  
    foreach ($Settings as $Key => $Setting) {
        $GTU_L_Settings->$Setting = get_site_option($Setting);
    }

    wp_register_script('GTU_L_Settings', '');
    wp_localize_script('GTU_L_Settings', 'GTU_L_Settings', json_encode($GTU_L_Settings));
    wp_enqueue_script('GTU_L_Settings');
}
add_action('wp_enqueue_scripts', 'GTU_L_Settings_JS');

function GTU_L_Tools_JS_Init()
{
    wp_enqueue_script('gtu_l_tools', plugin_dir_url(__FILE__) . 'gtu_l_tools.js');
}
add_action('wp_enqueue_scripts', 'GTU_L_Tools_JS_Init');

//function GTU_L_FormAutofillLocation_Init() { echo '<script>GTU_L_FormAutofillLocation(29);</script>'; } add_action( 'wp_footer', 'GTU_L_FormAutofillLocation_Init', 0 );

if (!function_exists('Test')) { // PHP script to dump variable into JavaScript console on front-end.
    function Test($output, $with_script_tags = false)
    {
        $js_code = json_encode($output, JSON_HEX_TAG);
        if ($with_script_tags === false) {
            echo '<script>console.log("GTU Test: " + ' . json_encode($js_code) . ');</script>';
        } else {
            echo "<pre>" . var_dump($js_code) . "</pre>";
        }
    }
}

function get_subdomain_post(){
    $site_path = str_replace('/', '', get_blog_details()->path);
    $post_type = get_site_option('GTU_L_Settings_Lower');
    $post_name = is_main_site() ? get_site_option('GTU_L_Settings_Corporate'): $site_path;

    $args = array('post_type' => $post_type, 'name' => $post_name , 'numberposts' => 1);
    $key = sanitize_key(json_encode($args));
    
    $post = get_transient($key);

    if(!$post){
        $post = get_posts($args)[0];
        set_transient($key, $post);
    }

    return $post;
}

function load_gtu_posts(){
    $post_type = get_site_option('GTU_L_Settings_Lower');
    $args = array('post_type' => $post_type, 'numberposts' => -1);
        
    set_gtu_field('location_posts', get_posts($args));    
}

add_action("gtu/load_posts", 'load_gtu_posts', 1);

function get_gtu_field($filed_name){
    return isset($GLOBALS['GTU_L']->{$filed_name}) ? $GLOBALS['GTU_L']->{$filed_name} : null;
}

function set_gtu_field(string $filed_name, $value){
    return $GLOBALS['GTU_L']->{$filed_name} = $value;
}

function GTU_L_GetSubdomain_ID()
{   // Gets the Post ID (by blog details / post name) of the currently active location.
    $post = get_subdomain_post();   
    return isset($post) ? $post->ID : null;
}
function GTU_L_GetParent_ID()
{ // Gets the Post ID (by blog details / post name) of the parent post on the currently active location.
    $Location = str_replace('/', '', get_blog_details()->path);

    $OriginalBlogId = get_current_blog_id();
    switch_to_blog(1);
    $Posts = get_posts(array('post_type' => get_site_option('GTU_L_Settings_Lower'), 'numberposts' => 999));

    $PostID = '';
    $CorporateID = '';
    foreach ($Posts as $Post) {
        if ($Post->post_name == $Location) {
            $PostID = $Post->ID;
        }
        if ($Post->post_name == get_site_option('GTU_L_Settings_Corporate')) {
            $CorporateID = $Post->ID;
        }
    }
    if ($PostID) {
        return $PostID;
    } else if ($CorporateID) {
        return $CorporateID;
    } else {
        return null;
    }

    switch_to_blog($OriginalBlogId);
}
function GTU_L_LocalPrefix()
{ // Echoes a localized slug
    echo GTU_L_GetLocalPrefix();
}
function GTU_L_GetLocalPrefix()
{ // Returns a localized slug
    return get_blog_details()->siteurl;
}

function GTU_L_FormatHours($InputHours)
{ // returns cosmetic AM/PM string based on military time in text format.
    $Hours = explode(':', $InputHours);
    if ($Hours[0] > 12) {
        $Hours[0] -= 12;
        $Hours = implode(':', $Hours) . 'pm';
    } elseif ($Hours[0] == 12) {
        $Hours = implode(':', $Hours) . 'pm';
    } elseif ($Hours[0] == 0) {
        $Hours[0] = 12;
        $Hours = implode(':', $Hours) . 'am';
    } else {
        $Hours = implode(':', $Hours) . 'am';
    }

    return $Hours;
}
function GTU_L_FormatPhone($InputPhone)
{ // If string contains any letters, display exact string. If not, format (xxx)xxx-xxxx
    $Country = get_field('country', GTU_L_GetSubdomain_ID());
    if (strtolower($Country) == "us" || $Country == '' || strtolower($Country) == 'ca') {
        if (strlen((int)$InputPhone) == strlen((int)$InputPhone * 1)) {
            return ('(' . substr((int)$InputPhone, 0, 3) . ') ' . substr((int)$InputPhone, 3, 3) . '-' . substr((int)$InputPhone, 6, 4));
        } else {
            return $InputPhone;
        }
    } else {
        return '+' . $InputPhone;
    }
}
function GTU_L_DisplayPhoneLink($FieldName = 'phone', $DisplayText = ['', ''], $Classes = '')
{ // Prints Phone Buttons button using Location's "Address Phone" link.
    $IconClass = get_site_option('GTU_L_Settings_PhoneIcon');
    $Phone = get_field($FieldName, GTU_L_GetSubdomain_ID());
    echo ('<a href="tel:' . $Phone . '" class="' . $Classes . '"><i class="' . $IconClass . '"></i> ' . $DisplayText[0] . ' ' . GTU_L_FormatPhone($Phone) . ' ' . $DisplayText[1] . '</a>');
}
function GTU_L_AddLocationToAdminBar($admin_bar)
{
    if (is_admin() == false) {
        $admin_bar->add_menu(array(
            'id'    => 'edit-' . get_site_option('GTU_L_Settings_Lower'),
            'title' => 'Edit ' . get_site_option('GTU_L_Settings_Display'),
            'href'  => 'https://' . $_SERVER['HTTP_HOST'] . '/wp-admin/post.php?post=' . GTU_L_GetParent_ID() . '&action=edit&lang=en',
            'meta'  => array(
                'title' => __('Edit ' . get_site_option('GTU_L_Settings_Display')),
            ),
        ));
        $admin_bar->add_menu(array(
            'id'    => 'my-sub-item',
            'parent' => 'my-item',
            'title' => 'My Sub Menu Item',
            'href'  => '#',
            'meta'  => array(
                'title' => __('My Sub Menu Item'),
                'target' => '_blank',
                'class' => 'my_menu_item_class'
            ),
        ));
        $admin_bar->add_menu(array(
            'id'    => 'my-second-sub-item',
            'parent' => 'my-item',
            'title' => 'My Second Sub Menu Item',
            'href'  => '#',
            'meta'  => array(
                'title' => __('My Second Sub Menu Item'),
                'target' => '_blank',
                'class' => 'my_menu_item_class'
            ),
        ));
    }
}
add_action('admin_bar_menu', 'GTU_L_AddLocationToAdminBar', 100);
function GTU_L_DisplaySchema()
{
    if (get_site_option('GTU_L_Settings_SEO_DisplaySchema')) {
        $ShowSchema = false;
        $ParentBlogName = get_blog_details(array('blog_id' => 1));
        $Image = get_site_option('GTU_L_Settings_SEO_Icon');
        $Fields =     get_fields(GTU_L_GetSubdomain_ID());
        $Schema = '<script type="application/ld+json">
	{
		"@context":"http://schema.org",
		"@type":"LocalBusiness",
		"@id":"https://' . $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'] . '",
		"name":"' . $ParentBlogName->blogname;
        if ($Fields['city']) {
            $Schema .= ' ' . $Fields['city'] . '"';
        }
        if ($Image) {
            $Schema .= ',
		"image": "' . $Image . '"';
        }
        $Schema .= ',
		"url":"https://' . $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'] . '"';

        if ($Fields['phone']) {
            $Schema .= ',
		"telephone":"' . $Fields['phone'] . '"';
        }
        $Schema .= ',
		"priceRange":"$$"';

        if ($Fields['gtu_l_nap_social'] || $Fields['gmb_vanity']) {
            $First = true;
            $Schema .= ',
		"sameAs": [';

            foreach ($Fields['gtu_l_nap_social'] as $Social) {
                if ($First == true) {
                    $First = false;
                } else {
                    $Schema .= ',';
                }
                $Schema .= '
			"' . $Social . '"';
            }

            if ($Fields['gmb_vanity']) {
                if ($First == true) {
                    $First = false;
                } else {
                    $Schema .= ',';
                }
                $Schema .= '
			"' . $Fields['gmb_vanity'] . '"';
            }

            $Schema .= '
		]';
        }

        if ($Fields['street'] || $Fields['city'] || $Fields['state'] || $Fields['zip'] || $Fields['country']) {
            $Schema .= ',
		"address":{
			"@type":"PostalAddress"';
            if ($Fields['street']) {
                $Schema .= ',
			"streetAddress":"' . $Fields['street'] . '"';
            }
            if ($Fields['city']) {
                $Schema .= ',
			"addressLocality":"' . $Fields['city'] . '"';
            }
            if ($Fields['state']) {
                $Schema .= ',
			"addressRegion":"' . $Fields['state'] . '"';
            }
            if ($Fields['zip']) {
                $Schema .= ',
			"postalCode":"' . $Fields['zip'] . '"';
            }
            if ($Fields['country']) {
                $Schema .= ',
			"addressCountry":"' . $Fields['country'] . '"';
            } else {
                $Schema .= ',
			"addressCountry":"US"';
            }
            $Schema .= '
		}';
        }

        if ($Fields['latitude'] && $Fields['longitude']) {
            $Schema .= ',
		"geo": {
			"@type": "GeoCoordinates",
			"latitude": ' . $Fields['latitude'] . ',
			"longitude": ' . $Fields['longitude'] . '
		}';
        }




        $Schema .= '
	}
	</script>';

        echo $Schema;
    }
}
// add_action('wp_enqueue_scripts', 'GTU_L_DisplaySchema', 100);

function GTU_L_Delete_WP_Defaults($blog_id)
{
    wp_delete_post(1, true); // 'Hello World!' post
    wp_delete_post(2, true); // 'Sample page' page
}
add_action('wpmu_new_blog', 'GTU_L_Delete_WP_Defaults', 100, 1);
