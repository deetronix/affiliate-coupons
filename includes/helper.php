<?php
/**
 * Helper
 *
 * @package     AffiliateCoupons\Helper
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get options
 *
 * return array options or empty when not available
 */
function affcoups_get_options() {
    return get_option( 'affcoups_settings', array() );
}

/*
 * Public assets folder
 */
function affcoups_the_assets() {
    echo AFFCOUPS_URL . 'public/assets';
}

/*
 * Better debugging
 */
function affcoups_debug( $args, $title = false ) {

    if ( $title ) {
        echo '<h3>' . $title . '</h3>';
    }

    if ( $args ) {
        echo '<pre>';
        print_r($args);
        echo '</pre>';
    }
}