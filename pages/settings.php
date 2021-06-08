<?php

$options = get_site_option('gtu_localize');

?>

<style>
	.GTU_L_Settings_Row { padding: 5px 25px; clear: both; }
	.GTU_L_Settings_Label { font-weight: 700; }
	.GTU_L_Settings_Item { padding-right: 1%; float: left; text-align: center; }
</style>

<div>
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
		</div>

		<div style="padding-top:50px;">
			<h2>Geolocation Settings</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Does this site require geolocation?</div>
				<input type="checkbox" id="GTU_L_Settings_Geolocation" name="GTU_L_Settings_Geolocation" <?php if(get_site_option('GTU_L_Settings_Geolocation')=='1') {echo "checked";} ?> />
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="float-left">
					<div class="GTU_L_Settings_Label">If ID's should be updated after geolocation, what prefix should be updated?</div>
					<input type="text" id="GTU_L_Settings_Geolocation_Prefix" name="GTU_L_Settings_Geolocation_Prefix" value="<?php echo get_site_option('GTU_L_Settings_Geolocation_Prefix'); ?>" />
				</div>
				<div class="float-left" style="padding-left: 5%;">
					<div class="GTU_L_Settings_Label">What ID's should be updated content from the localized post's matching ACF Field?</div>
					<input type="text" style="width:100%;" id="GTU_L_Settings_Geolocation_Fields" name="GTU_L_Settings_Geolocation_Fields" value="<?php echo get_site_option('GTU_L_Settings_Geolocation_Fields'); ?>" />
				</div>
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Change menus classed with "<i>gtu_localize_href</i>" to localize experience?</div>
				<input type="checkbox" id="GTU_L_Settings_Geolocation_Localize_HREFs" name="GTU_L_Settings_Geolocation_Localize_HREFs" <?php if(get_site_option('GTU_L_Settings_Geolocation_Localize_HREFs')=='1') {echo "checked";} ?> />
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Run Additional Scripts after Geolocated?</div>
				<input type="text" id="GTU_L_Settings_Geolocation_Scripts" name="GTU_L_Settings_Geolocation_Scripts" placeholder="Location" value="<?php echo get_site_option('GTU_L_Settings_Geolocation_Scripts'); ?>" style="width: 50%;" />
			</div>
		</div>

		<div style="padding-top:50px;">
			<h2>Social Settings</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label GTU_L_Settings_Item">Allow Facebook<br><input type="checkbox" id="GTU_L_Settings_Social_Facebook" name="GTU_L_Settings_Social_Facebook" <?php if(get_site_option('GTU_L_Settings_Social_Facebook')=='1') {echo "checked";} ?> /></div>
				<div class="GTU_L_Settings_Label GTU_L_Settings_Item">Allow Instagram<br><input type="checkbox" id="GTU_L_Settings_Social_Instagram" name="GTU_L_Settings_Social_Instagram" <?php if(get_site_option('GTU_L_Settings_Social_Instagram')=='1') {echo "checked";} ?> /></div>
				<div class="GTU_L_Settings_Label GTU_L_Settings_Item">Allow Youtube<br><input type="checkbox" id="GTU_L_Settings_Social_Youtube" name="GTU_L_Settings_Social_Youtube" <?php if(get_site_option('GTU_L_Settings_Social_Youtube')=='1') {echo "checked";} ?> /></div>
				<div class="GTU_L_Settings_Label GTU_L_Settings_Item">Allow Pinterest<br><input type="checkbox" id="GTU_L_Settings_Social_Pinterest" name="GTU_L_Settings_Social_Pinterest" <?php if(get_site_option('GTU_L_Settings_Social_Pinterest')=='1') {echo "checked";} ?> /></div>
			</div>
		</div>
		
		<div style="padding-top:50px;">
			<h2>SEO Settings</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label GTU_L_Settings_Item">Display "Local Business" Schema<br><input type="checkbox" id="GTU_L_Settings_SEO_DisplaySchema" name="GTU_L_Settings_SEO_DisplaySchema" <?php if(get_site_option('GTU_L_Settings_SEO_DisplaySchema')=='1') {echo "checked";} ?> /></div>
			</div>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">What URL is the SEO image located at?</div>
				<input type="text" style="width:50%;" id="GTU_L_Settings_SEO_Icon" name="GTU_L_Settings_SEO_Icon" value="<?php echo get_site_option('GTU_L_Settings_SEO_Icon'); ?>" />
			</div>
		</div>

		<div style="padding-top:50px;">
			<h2>Store Locator Plus Settings (Beta)</h2>
			<div class="GTU_L_Settings_Row">
				<div class="GTU_L_Settings_Label">Allow Locations to auto-update SLP Save File?</div>
				<input type="checkbox" id="GTU_L_Settings_SLP" name="GTU_L_Settings_SLP" <?php if(get_site_option('GTU_L_Settings_SLP')=='1') {echo "checked";} ?> />
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