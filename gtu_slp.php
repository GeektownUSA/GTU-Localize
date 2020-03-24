<?php

function GTU_L_SLP_SaveLocation( $post_ID, $post, $update ) { // Runs functions after Locations are saved
	// Do something
} add_action( 'save_post_'.get_site_option('GTU_L_Settings_Lower'), 'GTU_L_SLP_SaveLocation', 10, 3 );
