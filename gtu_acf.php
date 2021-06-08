<?php
$is_acf_enabled = is_plugin_active('advanced-custom-fields-pro/acf.php') || is_plugin_active('advanced-custom-fields/acf.php');

if ($is_acf_enabled) {

	acf_add_local_field_group(array(
		'key' => 'gtu_l_nap',
		'title' => 'Location - NAP & Contact Information',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => sanitize_title(get_site_option('GTU_L_Settings_Display'))
				),
			),
		),
	)); { // Address
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'street',
			'label' => 'Street',
			'name' => 'street',
			'instructions' => 'All digits, street names, and suffixes. Example: "123 Main St."',
			'type' => 'text',
			'wrapper' => array(
				'width' => '20',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'street2',
			'label' => 'Street, Line 2',
			'name' => 'street2',
			'instructions' => 'Additional street information can be added here, if needed.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'required' => 0,
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'city',
			'label' => 'City',
			'name' => 'city',
			'instructions' => 'City where the location operates.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '20',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'state',
			'label' => 'State / Province',
			'name' => 'state',
			'instructions' => '2 letters only, always capitalized. Example: "MI".',
			'type' => 'text',
			'wrapper' => array(
				'width' => '10',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'zip',
			'label' => 'Zip',
			'name' => 'zip',
			'instructions' => '5 digits only.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '10',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'country',
			'label' => 'Country',
			'name' => 'country',
			'instructions' => '2-Digit Country code. Blank entries will be considered "US". (<a href="https://www.countrycode.org/">See a list of examples</a>). ',
			'type' => 'text',
			'wrapper' => array(
				'width' => '15',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
	} { // Phone / Fax
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'phone',
			'label' => 'Phone',
			'name' => 'phone',
			'instructions' => 'All 10 digits (including area code) with no formating. ie, "1234567890", not "(123) 456-7890".',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'fax',
			'label' => 'Fax',
			'name' => 'fax',
			'instructions' => 'All 10 digits (including area code) with no formating. ie, "1234567890", not "(123) 456-7890".',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
	} { // GMB
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'gmb_vanity',
			'label' => 'GMB Vanity',
			'name' => 'gmb_vanity',
			'instructions' => 'Visit "https://maps.google.com", search the location, then click "Share". Paste the link here.<br>Example: https://g.page/GeekTownUSA',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'gmb_embed',
			'label' => 'GMB Embed',
			'name' => 'gmb_embed',
			'instructions' => 'Visit "https://maps.google.com", search the location, then click "Share", then click "Embed a map". Copy everything in the first set of quotes after "src", not the entire iframe.<br>Example: https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2941.9224321402035!1sen!2sus',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
	}
	if (get_site_option('GTU_L_Settings_Geolocation')) { // Optional fields can be turned on/off in WP Network Settings
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'latitude',
			'label' => 'Latitude',
			'name' => 'latitude',
			'instructions' => 'Latitude in degrees, with 6+ digits of precision. Example: "42.4932017".<br>Note: This can be found by visiting the "GMB Vanity" location and checking the URL.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'longitude',
			'label' => 'Longitude',
			'name' => 'longitude',
			'instructions' => 'Longitude in degrees, with 6+ digits of precision. Example: "-83.4332549".<br>Note: This can be found by visiting the "GMB Vanity" location and checking the URL.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
	} { // Email Group
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'email_general',
			'label' => 'General Contact Email',
			'name' => 'email_general',
			'instructions' => 'Email address that all general contact forms should notify.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '20',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));

		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'sales_exists',
			'label' => 'Use Sales Email?',
			'name' => 'sales_exists',
			'instructions' => 'If set to "No", the "General Contact" email will be used.',
			'type' => 'radio',
			'choices' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'default_value' => 0,
			'layout' => 0,
			'wrapper' => array(
				'width' => '15',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'email_sales',
			'label' => 'Sales Email',
			'name' => 'email_sales',
			'instructions' => 'Email address that all sales contact forms should notify.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '20',
				'class' => '',
				'id' => '',
			),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'sales_exists',
						'operator' => '==',
						'value' => 1,
					),
				),
			)
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'employment_exists',
			'label' => 'Use Employment Email?',
			'name' => 'employment_exists',
			'instructions' => 'If set to "No", the "General Contact" email will be used.',
			'type' => 'radio',
			'choices' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'default_value' => 0,
			'layout' => 0,
			'wrapper' => array(
				'width' => '15',
				'class' => '',
				'id' => '',
			),
			'required' => 0
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'email_employment',
			'label' => 'Employment Email',
			'name' => 'email_employment',
			'instructions' => 'Email address that all employment contact forms should notify.',
			'type' => 'text',
			'wrapper' => array(
				'width' => '20',
				'class' => '',
				'id' => '',
			),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'employment_exists',
						'operator' => '==',
						'value' => 1,
					),
				),
			)
		));
	} { // Social Group
		acf_add_local_field(array(
			'parent' => 'gtu_l_nap',
			'key' => 'gtu_l_nap_social',
			'label' => 'Social Platforms',
			'name' => 'gtu_l_nap_social',
			'instructions' => 'Social fields can be activated in the <a href="https://' . $_SERVER['HTTP_HOST'] . '/wp-admin/network/settings.php?page=gtu-l-settings">settings panel</a>.',
			'type' => 'group',
			'required' => 0
		));
		if (get_site_option('GTU_L_Settings_Social_Facebook')) {
			acf_add_local_field(array(
				'parent' => 'gtu_l_nap_social',
				'key' => 'social_facebook',
				'label' => 'Facebook',
				'name' => 'social_facebook',
				'instructions' => 'Example: https://www.facebook.com/GeekTownUSA/',
				'type' => 'text',
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
		}
		if (get_site_option('GTU_L_Settings_Social_Instagram')) {
			acf_add_local_field(array(
				'parent' => 'gtu_l_nap_social',
				'key' => 'social_instagram',
				'label' => 'Instagram',
				'name' => 'social_instagram',
				'instructions' => 'Example: https://www.instagram.com/GeekTownUSA/',
				'type' => 'text',
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
		}
		if (get_site_option('GTU_L_Settings_Social_Youtube')) {
			acf_add_local_field(array(
				'parent' => 'gtu_l_nap_social',
				'key' => 'social_youtube',
				'label' => 'Youtube',
				'name' => 'social_youtube',
				'instructions' => 'Example: https://www.youtube.com/GeekTownUSA/',
				'type' => 'text',
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
		}
		if (get_site_option('GTU_L_Settings_Social_Pinterest')) {
			acf_add_local_field(array(
				'parent' => 'gtu_l_nap_social',
				'key' => 'social_pinterest',
				'label' => 'Pinterest',
				'name' => 'social_pinterest',
				'instructions' => 'Example: https://www.pinterest.com/GeekTownUSA/',
				'type' => 'text',
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
		}
	}


	acf_add_local_field_group(array(
		'key' => 'gtu_l_hours',
		'title' => 'Location - Hours & Reviews',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => sanitize_title(get_site_option('GTU_L_Settings_Display'))
				),
			),
		),
	)); { // Hours Group
		{ // Monday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_mon',
				'label' => 'Monday Hours',
				'name' => 'gtu_l_hours_mon',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'mon_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_open',
				'label' => 'Monday - Open',
				'name' => 'mon_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'mon_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_close',
				'label' => 'Monday - Close',
				'name' => 'mon_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'mon_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'mon_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'mon_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_reopen',
				'label' => 'Monday - Re-Open',
				'name' => 'mon_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'mon_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_mon',
				'key' => 'mon_reclose',
				'label' => 'Monday - Re-Close',
				'name' => 'mon_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'mon_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Tuesday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_tue',
				'label' => 'Tuesday Hours',
				'name' => 'gtu_l_hours_tue',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'tue_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_open',
				'label' => 'Tuesday - Open',
				'name' => 'tue_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'tue_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_close',
				'label' => 'Tuesday - Close',
				'name' => 'tue_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'tue_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'tue_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'tue_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_reopen',
				'label' => 'Tuesday - Re-Open',
				'name' => 'tue_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'tue_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_tue',
				'key' => 'tue_reclose',
				'label' => 'Tuesday - Re-Close',
				'name' => 'tue_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'tue_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Wednesday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_wed',
				'label' => 'Wednesday Hours',
				'name' => 'gtu_l_hours_wed',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'wed_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_open',
				'label' => 'Wednesday - Open',
				'name' => 'wed_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'wed_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_close',
				'label' => 'Wednesday - Close',
				'name' => 'wed_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'wed_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'wed_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'wed_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_reopen',
				'label' => 'Wednesday - Re-Open',
				'name' => 'wed_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'wed_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_wed',
				'key' => 'wed_reclose',
				'label' => 'Wednesday - Re-Close',
				'name' => 'wed_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'wed_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Thursday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_thu',
				'label' => 'Thursday Hours',
				'name' => 'gtu_l_hours_thu',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'thu_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_open',
				'label' => 'Thursday - Open',
				'name' => 'thu_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'thu_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_close',
				'label' => 'Thursday - Close',
				'name' => 'thu_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'thu_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'thu_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'thu_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_reopen',
				'label' => 'Thursday - Re-Open',
				'name' => 'thu_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'thu_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_thu',
				'key' => 'thu_reclose',
				'label' => 'Thursday - Re-Close',
				'name' => 'thu_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'thu_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Friday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_fri',
				'label' => 'Friday Hours',
				'name' => 'gtu_l_hours_fri',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'fri_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_open',
				'label' => 'Friday - Open',
				'name' => 'fri_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'fri_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_close',
				'label' => 'Friday - Close',
				'name' => 'fri_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'fri_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'fri_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'fri_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_reopen',
				'label' => 'Friday - Re-Open',
				'name' => 'fri_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'fri_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_fri',
				'key' => 'fri_reclose',
				'label' => 'Friday - Re-Close',
				'name' => 'fri_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'fri_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Saturday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_sat',
				'label' => 'Saturday Hours',
				'name' => 'gtu_l_hours_sat',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'sat_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_open',
				'label' => 'Saturday - Open',
				'name' => 'sat_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sat_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_close',
				'label' => 'Saturday - Close',
				'name' => 'sat_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sat_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'sat_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sat_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_reopen',
				'label' => 'Saturday - Re-Open',
				'name' => 'sat_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sat_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sat',
				'key' => 'sat_reclose',
				'label' => 'Saturday - Re-Close',
				'name' => 'sat_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sat_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		} { // Sunday
			acf_add_local_field(array(
				'key' => 'gtu_l_hours_sun',
				'label' => 'Sunday Hours',
				'name' => 'gtu_l_hours_sun',
				'parent' => 'gtu_l_hours',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'layout' => 'block',
				'sub_fields' => [],
			));

			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_business_open',
				'label' => 'Is this store open for business?',
				'name' => 'sun_business_open',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'Closed',
					1 => 'Open'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_open',
				'label' => 'Sunday - Open',
				'name' => 'sun_open',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sun_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_close',
				'label' => 'Sunday - Close',
				'name' => 'sun_close',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sun_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_business_reopen',
				'label' => 'Does this store close and reopen mid-day?',
				'name' => 'sun_business_reopen',
				'instructions' => '',
				'type' => 'radio',
				'choices' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'default_value' => 0,
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sun_business_open',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_reopen',
				'label' => 'Sunday - Re-Open',
				'name' => 'sun_reopen',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sun_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
			acf_add_local_field(array(
				'parent' => 'gtu_l_hours_sun',
				'key' => 'sun_reclose',
				'label' => 'Sunday - Re-Close',
				'name' => 'sun_reclose',
				'instructions' => 'Military time. Example: "14:00", not "2:00pm".',
				'type' => 'text',
				'wrapper' => array(
					'width' => '16',
					'class' => '',
					'id' => '',
				),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'sun_business_reopen',
							'operator' => '==',
							'value' => 1,
						),
					),
				)
			));
		}
	} { // Reviews
		acf_add_local_field(array(
			'key' => 'gtu_l_hours_reviews',
			'label' => 'Reviews',
			'name' => 'gtu_l_hours_reviews',
			'parent' => 'gtu_l_hours',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => [
				'width' => '',
				'class' => '',
				'id' => '',
			],
			'layout' => 'table',
			'sub_fields' => [],
		));

		acf_add_local_field(array(
			'parent' => 'gtu_l_hours_reviews',
			'key' => 'review',
			'label' => 'Review',
			'name' => 'review',
			'type' => 'text',
			'instructions' => 'Review content.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '70',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_hours_reviews',
			'key' => 'review_author',
			'label' => 'Review Author',
			'name' => 'review_author',
			'type' => 'text',
			'instructions' => 'First and Last Name.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '15',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		));
		acf_add_local_field(array(
			'parent' => 'gtu_l_hours_reviews',
			'key' => 'stars',
			'label' => 'Rating',
			'name' => 'stars',
			'type' => 'text',
			'instructions' => 'Example: "2", not "2/5".',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '15',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		));
	}
} 
// else {
// 	Test("ACF is not installed properly. Please check your plugin settings.");
// }
