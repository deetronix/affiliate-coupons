<?php
/**
 * Install routine
 */
function affcoups_install() {

	update_option( 'affcoups_is_installed', '1' );
	update_option( 'affcoups_version', AFFCOUPS_VERSION );
}
register_activation_hook( AFFCOUPS_PLUGIN_FILE, 'affcoups_install' );

/**
 * Check whether our plugin is installed or not
 */
function affcoups_check_if_installed() {

	// this is mainly for network activated installs
	if( ! get_option( 'affcoups_is_installed' ) ) {
        affcoups_install();
	}
}
add_action( 'admin_init', 'affcoups_check_if_installed' );
