=== Affiliate Coupons - The #1 WordPress Coupon Plugin for Affiliate Marketers ===
Contributors: flowdee
Donate link: https://donate.flowdee.de
Tags: affiliate coupons, coupon plugin, coupon, wp coupons, coupon reveal
Requires at least: 3.0.1
Requires PHP: 5.6.0
Tested up to: 5.3.2
Stable tag: 1.5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Earn more money with the best affiliate coupons plugin for WordPress.

== Description ==

Earn more money with the best Affiliate Coupons plugin for WordPress.

= Features =

*   Create vendors and predefine affiliate links
*   Create coupons and link them to vendors
*   Display coupons via shortcode on the frontend
*   Multiple options in order to filter/sort your coupon presentations
*   Configuration page for more options and customizations
*   Prepared templates: Standard, Grid & List
*   Widgets for displaying coupons in your sidebar
*   Try out the **[online demo](https://affcoups.com/demo/?utm_source=wordpress.org&utm_medium=textlink&utm_campaign=Affiliate%20Coupons&utm_content=demo-link)**
*   Overview of all available **[templates](https://affcoups.com/templates/?utm_source=wordpress.org&utm_medium=textlink&utm_campaign=Affiliate%20Coupons&utm_content=templates-link)**
*   Regular updates and improvements: Go though the [changelog](https://wordpress.org/plugins/affiliate-coupons/#developers)

= Quickstart Examples =

*   Create vendors
*   Create coupons
*   Link coupons to vendors
*   Assign categories and/or types to coupons if needed
*   Display coupons inside your posts/pages by using shortcodes

= More features with the PRO version =

The PRO version extends this plugins exclusively with our "click to reveal" feature and more:

*   Click to reveal discount codes
*   View, copy & click statistics
*   Choose from different styles
*   Additional templates
*   Feature & highlight single coupons
*   Popular coupons widget
*   Event Tracking via Google & Piwik
*   Create custom templates

Details and upgrade can be found **[here](https://affcoups.com/features/?utm_source=wordpress.org&utm_medium=textlink&utm_campaign=Affiliate%20Coupons&utm_content=pro-version-link)**.

= Support =

* Browse [issue tracker](https://github.com/flowdee/affiliate-coupons/issues) on GitHub
* [Follow us on Twitter](https://twitter.com/affcoups) to stay in contact and informed about updates

== Installation ==

The installation and configuration of the plugin is as simple as it can be.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'affiliate coupons'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `affiliate-coupons.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `affiliate-coupons.zip`
2. Extract the `affiliate-coupons` directory to your computer
3. Upload the `affiliate-coupons` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= Multisite supported? =

Yes of course.

== Screenshots ==

1. Coupons Grid
2. Settings

== Changelog ==

= Version 1.5.5 (21th December 2019) =
* Fix: Hiding invalid and/or expired coupons didn't work as expected
* WordPress v5.3.2 compatibility

= Version 1.5.4 (17th December 2019) =
* New: Added setting and shortcode attribute for hiding coupons which are not valid yet
* New: Added "Credits" setting
* Fix: Order by "valid until" didn't work properly
* Fix: Escaping issue on settings page "Quick Start" guide
* Updated dependency "Meta Box" to latest v5.2.4
* WordPress v5.3.1 compatibility

= Version 1.5.3 (25th January 2019) =
* Tweak: Optimized coupon code copy to clipboard handling
* Fix: Coupon category and type metabox didn't show up in the sidebar of Gutenberg editor
* Updated Clipboard.JS dependency to latest v2.0.4
* WordPress v5.0.3 compatibility

= Version 1.5.2 (17th December 2018) =
* Tweak: Enabled new Gutenberg editor for coupon posts
* Updated Quickstart Guide
* Updated dependency "Meta Box" to latest v4.15.9
* WordPress v5.0.1 compatibility

= Version 1.5.1 (20th November 2018) =
* Tweak: Setting a coupon "valid from" date now uses 23:59 as default time
* Tweak: Optimized loading of plugin core files
* Fix: Grid size wasn't taken properly from plugin settings
* Updated .pot file and removed unneeded translation strings

= Version 1.5.0 (11th November 2018) =
* New: Redesigned & restructured settings page
* New: Clipboard icon can now selected via settings (3 different icons and 2 colors are available to be chosen from)
* New: Clipboard background & font colors can now be overwritten via settings
* New: Added new button icon and 2 colors (black & white)
* New: Added setting which allows you to hide coupon dates on the front end
* Tweak: Removed third party plugin installation dependency
* Tweak: Optimized coupons admin overview page
* Tweak: Optimized templates & styles
* Tweak: Added install & uninstall routines
* WordPress v4.9.8 compatibility

= Version 1.4.1 (18th June 2018) =
* Tweak: Removed directly included metabox dependency and switched over to "TGM_Plugin_Activation" class instead
* Tweak: Added fallback for "rwmb_meta" function
* Fix: "Fatal error: Uncaught Error: Class 'RWMB_About' not found"

= Version 1.3.2 (17th June 2018) =
* Fix: Settings section headlines were not output correctly
* Updated dependency "Meta Box" to latest v4.14.11
* WordPress v4.9.6 compatibility

= Version 1.3.1 (28th April 2018) =
* New: Overwrite coupon image with post thumbnail
* Fix: Custom CSS output

= Version 1.3.0 (24th April 2018) =
* New: Added multiple coupons widget
* Tweak: Security
* WordPress v4.9.5 compatibility

= Version 1.2.2 (30th November 2017) =
* New: Added setting in order to adjust the default excerpt length
* Tweak: Remove unwanted line breaks from shortcode output
* Fix: "PHP Fatal error: Uncaught ArgumentCountError: Too few arguments to function affcoups_widget_text()"
* WordPress v4.9.1 compatibility

= Version 1.2.1 (28th November 2017) =
* New: Added a brand new list template
* New: Added a new widget for displaying a single coupon in your sidebar
* New: Added new setting in order to customize button colors
* New: Added new setting in order to customize discount ribbon colors
* Tweak: When setting up a valid from/to date you are now able to choose as time as well
* Tweak: Added type slug as class in templates in order to make it customizable
* Tweak: Display recommended image size besides the image upload fields
* Tweak: Tweaked shortcode previews inside admin area
* Tweak: Adjusted default thumbnail size to 480*270px
* Tweak: Optimized CSS in order to remove border from thumbnail link
* Tweak: Updated plugin icons inside admin area
* Fix: Expiring on the same day leads into now showing coupon
* Fix: Custom CSS was not being outputted correctly on special pages (e.g. front page)
* WordPress v4.9 compatibility
* Updated dependency "Meta Box" to latest version 4.12.5

= Version 1.2.0 (7th November 2017) =
* New: Added support for Google Accelerated Mobile (AMP)
* Tweak: Enhanced CSS styles in order to display a grid with up to 10 columns
* Tweak: Added prefixes to plugin related post types on admin export page
* Fix: HTML and apostrophes inside link/image titles and alt tags lead into markup issues
* Fix: Issue which was related to "term_taxonomy_id" while executing our coupon query
* Fix: Thumbnail previews on manage coupons/vendors pages might be shown too big
* Fix: Registering custom image sizes was accidentally loaded in admin area only
* Updated plugin branding and links
* Updated dependency "Meta Box" to latest version 4.12.4

= Version 1.1.3 (7th June 2017) =
* Tweak: Optimize scripts loading
* Tweak: Optimized CSS styles
* Fix: Custom CSS not being inserted correctly
* Minor improvements
* Updated templates: grid.php, standard.php

= Version 1.1.2 (3rd June 2017) =
* New: Added shortcode preview to admin coupons overview page
* New: Added shortcode preview to admin categories overview page
* New: Added shortcode preview to admin types overview page
* Fix: Since the latest update, thumbnail images didn't show up correctly
* Fix: Admin vendors overview page showed incorrect shortcode preview

= Version 1.1.1 (2nd June 2017) =
* Tweak: Set default grid size back to 3
* Fix: Removed shortcode debugging :)

= Version 1.1.0 (2nd June 2017) =
* New: Display single coupons by id
* New: Display coupons from a specific vendor
* New: Sort coupons on a shortcode basis
* New: Added more setting options (template, grid size, order, orderby, button text, button icon)
* New: Button text can be overwritten via shortcode attribute "button_text"
* Tweak: Added links to coupon thumbnails
* Tweak: Optimized CSS styles
* Tweak: Optimized scripts loading
* Fix: Post types appeared in sitemaps and search results
* Changed shortcode from "affcoups_coupons" to "affcoups" (added fallback for previous shortcode)

= Version 1.0.1 (9th August 2016) =
* Tweak: Optimized settings quickstart explanation for categories/types
* Tweak: Made "Copied!" label translatable
* Fix: Only 5 coupons appearing for a category
* Fix: Fatal error: Can't use function return value in write context ... coupons-grid.php on line 48

= Version 1.0.0 (30th July 2016) =
* Initial release

== Upgrade Notice ==

= Version 1.5.5 (21th December 2019) =
* Fix: Hiding invalid and/or expired coupons didn't work as expected
* WordPress v5.3.2 compatibility

= Version 1.5.4 (17th December 2019) =
* New: Added setting and shortcode attribute for hiding coupons which are not valid yet
* New: Added "Credits" setting
* Fix: Order by "valid until" didn't work properly
* Fix: Escaping issue on settings page "Quick Start" guide
* Updated dependency "Meta Box" to latest v5.2.4
* WordPress v5.3.1 compatibility

= Version 1.5.3 (25th January 2019) =
* Tweak: Optimized coupon code copy to clipboard handling
* Fix: Coupon category and type metabox didn't show up in the sidebar of Gutenberg editor
* Updated Clipboard.JS dependency to latest v2.0.4
* WordPress v5.0.3 compatibility

= Version 1.5.2 (17th December 2018) =
* Tweak: Enabled new Gutenberg editor for coupon posts
* Updated Quickstart Guide
* Updated dependency "Meta Box" to latest v4.15.9
* WordPress v5.0.1 compatibility

= Version 1.5.1 (20th November 2018) =
* Tweak: Setting a coupon "valid from" date now uses 23:59 as default time
* Tweak: Optimized loading of plugin core files
* Fix: Grid size wasn't taken properly from plugin settings
* Updated .pot file and removed unneeded translation strings

= Version 1.5.0 (11th November 2018) =
* New: Redesigned & restructured settings page
* New: Clipboard icon can now selected via settings (3 different icons and 2 colors are available to be chosen from)
* New: Clipboard background & font colors can now be overwritten via settings
* New: Added new button icon and 2 colors (black & white)
* New: Added setting which allows you to hide coupon dates on the front end
* Tweak: Removed third party plugin installation dependency
* Tweak: Optimized coupons admin overview page
* Tweak: Optimized templates & styles
* Tweak: Added install & uninstall routines
* WordPress v4.9.8 compatibility

= Version 1.4.1 (18th June 2018) =
* Tweak: Removed directly included metabox dependency and switched over to "TGM_Plugin_Activation" class instead
* Tweak: Added fallback for "rwmb_meta" function
* Fix: "Fatal error: Uncaught Error: Class 'RWMB_About' not found"

= Version 1.3.2 (17th June 2018) =
* Fix: Settings section headlines were not output correctly
* Updated dependency "Meta Box" to latest v4.14.11
* WordPress v4.9.6 compatibility

= Version 1.3.1 (28th April 2018) =
* New: Overwrite coupon image with post thumbnail
* Fix: Custom CSS output

= Version 1.3.0 (24th April 2018) =
* New: Added multiple coupons widget
* Tweak: Security
* WordPress v4.9.5 compatibility

= Version 1.2.2 (30th November 2017) =
* New: Added setting in order to adjust the default excerpt length
* Tweak: Remove unwanted line breaks from shortcode output
* Fix: "PHP Fatal error: Uncaught ArgumentCountError: Too few arguments to function affcoups_widget_text()"
* WordPress v4.9.1 compatibility

= Version 1.2.1 (28th November 2017) =
* New: Added a brand new list template
* New: Added a new widget for displaying a single coupon in your sidebar
* New: Added new setting in order to customize button colors
* New: Added new setting in order to customize discount ribbon colors
* Tweak: When setting up a valid from/to date you are now able to choose as time as well
* Tweak: Added type slug as class in templates in order to make it customizable
* Tweak: Display recommended image size besides the image upload fields
* Tweak: Tweaked shortcode previews inside admin area
* Tweak: Adjusted default thumbnail size to 480*270px
* Tweak: Optimized CSS in order to remove border from thumbnail link
* Tweak: Updated plugin icons inside admin area
* Fix: Expiring on the same day leads into now showing coupon
* Fix: Custom CSS was not being outputted correctly on special pages (e.g. front page)
* WordPress v4.9 compatibility
* Updated dependency "Meta Box" to latest version 4.12.5

= Version 1.2.0 (7th November 2017) =
* New: Added support for Google Accelerated Mobile (AMP)
* Tweak: Enhanced CSS styles in order to display a grid with up to 10 columns
* Tweak: Added prefixes to plugin related post types on admin export page
* Fix: HTML and apostrophes inside link/image titles and alt tags lead into markup issues
* Fix: Issue which was related to "term_taxonomy_id" while executing our coupon query
* Fix: Thumbnail previews on manage coupons/vendors pages might be shown too big
* Fix: Registering custom image sizes was accidentally loaded in admin area only
* Updated plugin branding and links
* Updated dependency "Meta Box" to latest version 4.12.4

= Version 1.1.3 (7th June 2017) =
* Tweak: Optimize scripts loading
* Tweak: Optimized CSS styles
* Fix: Custom CSS not being inserted correctly
* Minor improvements
* Updated templates: grid.php, standard.php

= Version 1.1.2 (3rd June 2017) =
* New: Added shortcode preview to admin coupons overview page
* New: Added shortcode preview to admin categories overview page
* New: Added shortcode preview to admin types overview page
* Fix: Since the latest update, thumbnail images didn't show up correctly
* Fix: Admin vendors overview page showed incorrect shortcode preview

= Version 1.1.1 (2nd June 2017) =
* Tweak: Set default grid size back to 3
* Fix: Removed shortcode debugging :)

= Version 1.1.0 (2nd June 2017) =
* New: Display single coupons by id
* New: Display coupons from a specific vendor
* New: Sort coupons on a shortcode basis
* New: Added more setting options (template, grid size, order, orderby, button text, button icon)
* New: Button text can be overwritten via shortcode attribute "button_text"
* Tweak: Added links to coupon thumbnails
* Tweak: Optimized CSS styles
* Tweak: Optimized scripts loading
* Fix: Post types appeared in sitemaps and search results
* Changed shortcode from "affcoups_coupons" to "affcoups" (added fallback for previous shortcode)

= Version 1.0.1 (9th August 2016) =
* Tweak: Optimized settings quickstart explanation for categories/types
* Tweak: Made "Copied!" label translatable
* Fix: Only 5 coupons appearing for a category
* Fix: Fatal error: Can't use function return value in write context ... coupons-grid.php on line 48

= Version 1.0.0 (30th July 2016) =
* Initial release