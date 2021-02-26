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

	/**
	 *Settings page only
	 */
	$screen = get_current_screen();

	if ( affcoups_is_plugin_admin_area() || ( isset( $screen->base ) && 'widgets' === $screen->base ) ) {

		wp_enqueue_style( 'wp-color-picker' );

  		wp_enqueue_script( 'affcoups-admin', AFFCOUPS_PLUGIN_URL . 'assets/dist/js/admin.js', array(
			'jquery',
			'wp-color-picker'
		), AFFCOUPS_VERSION );
		wp_enqueue_style( 'affcoups-admin', AFFCOUPS_PLUGIN_URL . 'assets/dist/css/admin.css', false, AFFCOUPS_VERSION );

        wp_localize_script( 'affcoups-admin', 'affcoups_admin_post', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => array(
                'remove_review_request' => wp_create_nonce( 'remove_review_request' ),
                'hide_review_request'   => wp_create_nonce( 'hide_review_request' ),
            )
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

	wp_enqueue_script( 'affcoups', AFFCOUPS_PLUGIN_URL . 'assets/dist/js/main.js', array( 'jquery' ), AFFCOUPS_VERSION, true );
	wp_enqueue_style( 'affcoups', AFFCOUPS_PLUGIN_URL . 'assets/dist/css/main.css', false, AFFCOUPS_VERSION );

    wp_localize_script( 'affcoups', 'affcoups_post', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));

	do_action( 'affcoups_enqueue_scripts' );
}

add_action( 'wp_enqueue_scripts', 'affcoups_scripts' );
