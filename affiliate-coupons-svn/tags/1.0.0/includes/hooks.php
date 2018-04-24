<?php
/**
 * Hooks
 *
 * @package     AffiliateCoupons\Hooks
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Register new image sizes
 */
function affcoups_add_image_sizes() {
    add_image_size( 'affcoups-thumb', 480, 250, array( 'center', 'top' ) );
    add_image_size( 'affcoups-thumb-small', 144, 75, array( 'center', 'top' ) );
}
add_action( 'admin_init', 'affcoups_add_image_sizes' );
