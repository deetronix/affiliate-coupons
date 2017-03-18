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
 * Convert separated strings to array
 *
 * @param $string
 * @return array
 */
function affcoups_convert_separated_strings_to_array( $string ) {

    // Remove spaces
    $string = str_replace( ' ', '', $string);

    // Convert to array
    $array = explode( ',', $string );

    return $array;
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