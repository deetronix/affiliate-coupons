<?php
/**
 * Uninstall Affiliate Coupons
 *
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Load core file
include_once( 'affiliate-coupons.php' );

$affcoups_options = get_option( 'affcoups_settings', array() );

if( isset( $affcoups_options['uninstall_on_delete'] ) && '1' == $affcoups_options['uninstall_on_delete'] ) {

	if ( is_multisite() ) {

		if ( true === version_compare( $GLOBALS['wp_version'], '4.6', '<' ) ) {
			$sites = wp_list_pluck( 'blog_id', wp_get_sites() );
		} else {
			$sites = get_sites( array( 'fields' => 'ids' ) );
		}

		// Remove all database tables
		foreach ( $sites as $site_id ) {

			switch_to_blog( $site_id );

            affcoups_delete_options();

			restore_current_blog();

		}

	} else {

        affcoups_delete_options();

	}
}

/**
 * Delete options
 */
function affcoups_delete_options() {

    $options = array(
        'affcoups_is_installed',
        'affcoups_version',
        'affcoups_settings',
        'affcoups_review_request_suppressed',
        'affcoups_log'
    );

    foreach ( $options as $option ) {
        delete_option( $option );
    }
}
