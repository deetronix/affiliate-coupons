<?php
/**
 * Scripts
 *
 * @package     AffiliateCoupons\Scripts
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load admin scripts
 *
 * @since       1.0.0
 * @global      string $post_type The type of post that we are editing
 * @return      void
 */
function affcoups_admin_scripts( $hook ) {

	// Use minified libraries if SCRIPT_DEBUG is turned off
//	$suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? '' : '.min';

	/**
	 *Settings page only
	 */
	$screen = get_current_screen();

	if ( affcoups_is_plugin_admin_area() || ( isset( $screen->base ) && 'widgets' === $screen->base ) ) {

		wp_enqueue_style( 'wp-color-picker' );

//		wp_enqueue_script( 'affcoups-admin-script', AFFCOUPS_PLUGIN_URL . 'public/js/admin' . $suffix . '.js', array(
//			'jquery',
//			'wp-color-picker'
//		), AFFCOUPS_VERSION );
//		wp_enqueue_style( 'affcoups-admin-style', AFFCOUPS_PLUGIN_URL . 'public/css/admin' . $suffix . '.css', false, AFFCOUPS_VERSION );

  		wp_enqueue_script( 'affcoups-admin-script', AFFCOUPS_PLUGIN_URL . 'assets/dist/admin.js', array(
			'jquery',
			'wp-color-picker'
		), AFFCOUPS_VERSION );
		wp_enqueue_style( 'affcoups-admin-style', AFFCOUPS_PLUGIN_URL . 'assets/dist/admin.css', false, AFFCOUPS_VERSION );

        wp_localize_script( 'affcoups-admin-script', 'affcoups_admin_post', array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ));

		do_action( 'affcoups_enqueue_admin_scripts' );
	}
}

add_action( 'admin_enqueue_scripts', 'affcoups_admin_scripts', 100 );

/**
 * Load frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function affcoups_scripts( $hook ) {

	// Use minified libraries if SCRIPT_DEBUG is turned off
//	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

//	wp_enqueue_script( 'affcoups-script', AFFCOUPS_PLUGIN_URL . 'public/js/scripts' . $suffix . '.js', array( 'jquery' ), AFFCOUPS_VERSION, true );
//	wp_enqueue_style( 'affcoups-style', AFFCOUPS_PLUGIN_URL . 'public/css/styles' . $suffix . '.css', false, AFFCOUPS_VERSION );

	wp_enqueue_script( 'affcoups-script', AFFCOUPS_PLUGIN_URL . 'assets/dist/main.js', array( 'jquery' ), AFFCOUPS_VERSION, true );
	wp_enqueue_style( 'affcoups-style', AFFCOUPS_PLUGIN_URL . 'assets/dist/main.css', false, AFFCOUPS_VERSION );

    wp_localize_script( 'affcoups-script', 'affcoups_post', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));

	do_action( 'affcoups_enqueue_scripts' );
}

add_action( 'wp_enqueue_scripts', 'affcoups_scripts' );
