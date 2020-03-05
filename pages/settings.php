<?php

$options = get_site_option('gtu_localize');

?>

<style>
	.GTU_L_Settings_Row { padding: 5px 0px; }
	.GTU_L_Settings_Label { font-weight: 700; }
</style>

<div style="max-width: 1024px;">
	<form method="post" action="<?php echo admin_url('admin-post.php?action=update_my_settings'); ?>" method="post">
		<?php wp_nonce_field( '_GTU_L_Settings_Nonce' ); ?>

		<div>
			<h2>Localization Settings</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Display Name (singular)</div>
				<input type="text" id="GTU_L_Settings_Display" name="GTU_L_Settings_Display" placeholder="Location" value="<?php echo get_site_option('GTU_L_Settings_Display'); ?>" />
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Display Icon <a target="_blank" href="https://developer.wordpress.org/resource/dashicons/#welcome-widgets-menus">(see options here)</a></div>
				<input type="text" id="GTU_L_Settings_Icon" name="GTU_L_Settings_Icon" placeholder="dashicons-store" value="<?php echo get_site_option('GTU_L_Settings_Icon'); ?>" />
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">What is the slug of your corporate installation?</div>
				<input type="text" id="GTU_L_Settings_Corporate" name="GTU_L_Settings_Corporate" placeholder="corporate" value="<?php echo get_site_option('GTU_L_Settings_Corporate'); ?>" />
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Does this site require geolocation?</div>
				<input type="checkbox" id="GTU_L_Settings_Geolocation" name="GTU_L_Settings_Geolocation" <?php if(get_site_option('GTU_L_Settings_Geolocation')=='1') {echo "checked";} ?> />
			</div>
		</div>
		<div style="padding-top:50px;">
			<h2>Display Settings</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">What FA Icon would you like to display next to Phone CTA's?</div>
				<input type="text" id="GTU_L_Settings_PhoneIcon" name="GTU_L_Settings_PhoneIcon" placeholder="fas fa-phone" value="<?php echo get_site_option('GTU_L_Settings_PhoneIcon'); ?>" />
			</div>
		</div>
		<?php  submit_button(); ?>
	</form>
</div>