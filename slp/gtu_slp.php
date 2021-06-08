<?php

function GTU_L_SLP_SaveLocation( $post_ID, $post, $update ) { // Runs functions after Locations are saved
	$SkipSheet = false;
	if($post->post_title=="Auto Draft") { $SkipSheet = true; }
	
	if($SkipSheet==false) {
		$OriginalSheet = GTU_L_SLP_GetCSV();
		if($OriginalSheet) { // Only continue if it's the root installation
	//		Test($OriginalSheet);
			$NewSheet = GTU_L_SLP_UpdateSheet($OriginalSheet, $post);
	//		Test($NewSheet);
			GTU_L_SLP_SaveCSV($NewSheet);	
		}
	//	Test("--------------------");
	}
} add_action( 'save_post_'.get_site_option('GTU_L_Settings_Lower'), 'GTU_L_SLP_SaveLocation', 10, 3 );

function GTU_L_SLP_UpdateSheet($Sheet, $Post) {
	// If a Match is found, update the sheet. 
	foreach($Sheet as $Key => $Row) { if($Row['sl_store'] == $Post->post_title) { $Index = $Key; } }
	// If no Match was found, append the sheet.
	if(!isset($Index)) { $Index = count($Sheet); }

	{ // Create / Update this row
		// Remove this --v
		$Sheet[$Index]['sl_id'] = ''.($Index+1);
		$Sheet[$Index]['sl_store'] = $Post->post_title;
		$Sheet[$Index]['sl_address'] = get_field('street',$Post->id);
		$Sheet[$Index]['sl_address2'] = '';
		$Sheet[$Index]['sl_city'] = get_field('city',$Post->id);
		$Sheet[$Index]['sl_state'] = get_field('state',$Post->id);
		$Sheet[$Index]['sl_zip'] = get_field('zip',$Post->id);
		$Sheet[$Index]['sl_country'] = '';
		$Sheet[$Index]['sl_latitude'] = get_field('latitude',$Post->id);
		$Sheet[$Index]['sl_longitude'] = get_field('longitude',$Post->id);
		$Sheet[$Index]['sl_tags'] = '';
		$Sheet[$Index]['sl_description'] = '';
		$Sheet[$Index]['sl_email'] = get_field('email_general',$Post->id);
		$Sheet[$Index]['sl_url'] = 'https://'.$_SERVER['HTTP_HOST'].'/'.$Post->post_name;
		$Sheet[$Index]['sl_hours'] = '';
		if(get_field('phone',$Post->id)) { $Sheet[$Index]['sl_phone'] = GTU_L_FormatPhone(get_field('phone',$Post->id)); }
		else { $Sheet[$Index]['sl_phone'] = ''; }
		$Sheet[$Index]['sl_fax'] = '';
		$Sheet[$Index]['sl_image'] = '';
		$Sheet[$Index]['sl_private'] = '';
		$Sheet[$Index]['sl_neat_title'] = '';
		$Sheet[$Index]['featured'] = '';
		$Sheet[$Index]['rank'] = '';
		$Sheet[$Index]['category'] = '';
		$Sheet[$Index]['category_slug'] = '';
		$Sheet[$Index]['marker'] = '';
	}
	return $Sheet;
}
function GTU_L_SLP_SaveCSV($Sheet) { // Saves a CSV
	$file = fopen(wp_upload_dir()['basedir'].'/slp.csv', 'w');

	// Format header rows
	$HeaderRow = array();
	foreach($Sheet[0] as $Key=>$Val) {
		array_push($HeaderRow,$Key);	
	}
	fputcsv($file,$HeaderRow);

	// Place data in sheet
	foreach($Sheet as $Row) {
		$ThisRow='';
		foreach($Row as $Key=>$Value) {
			$ThisRow = $ThisRow.$Value.'***';
		}
		fputcsv($file,explode('***',$ThisRow));
	}

	fclose($file);
}
function GTU_L_SLP_GetCSV() { // Returns CSV as Object.
	if(file_exists(wp_upload_dir()['basedir'].'/slp.csv')) { $file = fopen(wp_upload_dir()['basedir'].'/slp.csv', 'r') or die('Unable to open file!'); }
	else { return false; die; }

	$Data = array();
	$X=0;
	while(($row = fgetcsv($file)) !== false){
		if($X==0) {
			$HeaderRow = $row;
		}
		else {
			$NewRow = array();
			foreach($row as $key=>$column) {
				if($key==0) { $ThisID = 'sl_id'; }
				else {
					if(array_key_exists($key,$HeaderRow)) {
						$ThisID = $HeaderRow[$key];
					}
				}

				if($ThisID) { $NewRow[$ThisID] = $row[$key]; }
			}
			array_push($Data,$NewRow);
		}
		$X++;
	}
	return $Data;

	
	fclose($file);
}