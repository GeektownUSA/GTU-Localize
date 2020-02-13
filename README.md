# GTU-Localize
Creates a Location structure for Corporations, stores local/corporate information for use in the front-end

# How It Works
This plugin works by creating a Custom Post Type for each "Location", and associating each "Location" with a WP Multisite installation. This plugin then deoes the following:
- Identifies which WPMS is active
- Stores common information in PHP Session data
- Sends PHP Session Data to JS object for use by other plugins
- Allows CPT to be used as a Location Finder, including support for browser GeoLocation and Zip Code location

# Version History
0.2.1
---
Fixed an issue where Geolocation replaced session data in some instances. When geolocation was turned off, locations could not be manually loaded.

0.2
---
Configuration was converted to subdirectories. Some functions were adjusted but not renamed.

0.1
---
Basic configuration, allowing support for Subdomain installations only.
