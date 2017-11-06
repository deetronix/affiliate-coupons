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
 * Cleanup string in order to be used inside html attributes (title, alt etc.) without breaking the markup
 *
 * @param $str
 * @return mixed
 */
function affcoups_cleanup_html_attribute( $str ) {

    // Remove html
    $str = strip_tags( $str );

    // Remove apostrophes
    $str = str_replace( array( '"', "'" ), '', $str );

    return $str;
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

/**
 * Public assets folder
 */
function affcoups_the_assets() {
    echo AFFCOUPS_URL . 'public/assets';
}

/**
 * Check whether it's development environment or not
 */
function affcoups_is_development() {
    return ( strpos( get_bloginfo('url'), 'affcoups.dev' ) !== false ) ? true : false;
}

/**
 * Get website url
 *
 * @param $path
 * @param string $source
 * @return string
 */
function affcoups_get_website_url( $path = '', $source = 'plugin-settings' ) {

    $url = 'https://affcoups.com/';

    if ( ! empty( $path ) )
        $url .= trim( $path,'/') . '/';

    return esc_url( add_query_arg( array(
            'utm_source'   => $source,
            'utm_medium'   => 'plugin-row',
            'utm_campaign' => 'Affiliate Coupons',
        ), $url )
    );
}

/**
 * Debug
 *
 * @param $args
 * @param bool $title
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



/**
 * Debug log
 *
 * @param $log
 */
function affcoups_debug_log ( $log )  {

    if ( ! affcoups_is_development() )
        return;

    if ( is_array( $log ) || is_object( $log ) ) {
        error_log( print_r( $log, true ) );
    } else {
        error_log( $log );
    }
}
