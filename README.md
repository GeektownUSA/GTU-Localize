# GTU-Localize
Creates a Location structure for Corporations, stores local/corporate information for use in the front-end

# How It Works
This plugin works by creating a Custom Post Type for each "Location", and associating each "Location" with a WP Multisite installation. This plugin then deoes the following:
- Identifies which WPMS is active
- Stores common information in PHP Session data
- Sends PHP Session Data to JS object for use by other plugins
- Allows CPT to be used as a Location Finder, including support for browser GeoLocation and Zip Code location

# Version History
0.3
---
Created back-end to save settings.
- Removed GTU_L_Settings()
- Removed $GLOBALS['GTU_L']->Settings
- GTU_L_location_post_type() now initializes $GLOBALS['GTU_L']
- Added functionality to use "update_site_option" for WP Multisite support.
Reorganized Plugin into multiple files using include_once.
- gtu_acf.php was created to house acf settings 
- /geolocation/ was created to house geolocation features, and dependent functionality.
- /pages/ was created to house template files
Added support for "Vanity Number" styling
"GTU_L_Phone" changed to "GTU_L_DisplayPhoneLink"
- Added a Plugin Setting to set FA Icons
- Removed function argument for FA Icons; default is set in the plugin.
Added GTU_L_FormatHours to convert military time into cosmetic AM/PM settings

0.2.1
---
Fixed an issue where Geolocation replaced session data in some instances. When geolocation was turned off, locations could not be manually loaded.

0.2
---
Configuration was converted to subdirectories. Some functions were adjusted but not renamed.

0.1
---
Basic configuration, allowing support for Subdomain installations only.
