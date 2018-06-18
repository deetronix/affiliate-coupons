<?php
/**
 * Bootstrap
 *
 * @package     AffiliateCoupons\Vendor
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once AFFCOUPS_DIR . 'includes/vendor/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'affcoups_register_required_plugins' );

/**
 * Register the required plugins for this plugin.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function affcoups_register_required_plugins() {

	$plugins = array(
		array(
			'name'     => 'Meta Box',
			'slug'     => 'meta-box',
			'required' => true,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'affiliate-coupons',
		// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',
		// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',
		// Menu slug.
		'parent_slug'  => 'plugins.php',
		// Parent menu slug.
		'capability'   => 'manage_options',
		// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,
		// Show admin notices or not.
		'dismissable'  => false,
		// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',
		// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,
		// Automatically activate plugins after installation or not.
		'message'      => '',
		// Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'affiliate-coupons' ),
			'menu_title'                      => __( 'Install Plugins', 'affiliate-coupons' ),
			/* translators: %s: plugin name. */
			'installing'                      => __( 'Installing Plugin: %s', 'affiliate-coupons' ),
			/* translators: %s: plugin name. */
			'updating'                        => __( 'Updating Plugin: %s', 'affiliate-coupons' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'affiliate-coupons' ),
			'notice_can_install_required'     => _n_noop(
			/* translators: 1: plugin name(s). */
				'Affiliate Coupons requires the following plugin: %1$s.',
				'Affiliate Coupons requires the following plugins: %1$s.',
				'affiliate-coupons'
			),
			'notice_can_install_recommended'  => _n_noop(
			/* translators: 1: plugin name(s). */
				'Affiliate Coupons recommends the following plugin: %1$s.',
				'Affiliate Coupons recommends the following plugins: %1$s.',
				'affiliate-coupons'
			),
			'notice_ask_to_update'            => _n_noop(
			/* translators: 1: plugin name(s). */
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this plugin: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this plugin: %1$s.',
				'affiliate-coupons'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
			/* translators: 1: plugin name(s). */
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'affiliate-coupons'
			),
			'notice_can_activate_required'    => _n_noop(
			/* translators: 1: plugin name(s). */
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'affiliate-coupons'
			),
			'notice_can_activate_recommended' => _n_noop(
			/* translators: 1: plugin name(s). */
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'affiliate-coupons'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'affiliate-coupons'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'affiliate-coupons'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'affiliate-coupons'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'affiliate-coupons' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'affiliate-coupons' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'affiliate-coupons' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'affiliate-coupons' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this plugin. Please update the plugin.', 'affiliate-coupons' ),
			/* translators: 1: dashboard link. */
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'affiliate-coupons' ),
			'dismiss'                         => __( 'Dismiss this notice', 'affiliate-coupons' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'affiliate-coupons' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'affiliate-coupons' ),

			'nag_type' => '',
			// Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	);

	tgmpa( $plugins, $config );
}
