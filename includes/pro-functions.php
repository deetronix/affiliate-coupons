<?php
/**
 * Pro Version Functions
 *
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check whether pro version is installed or not
 *
 * @return bool
 */
function affcoups_is_pro_version() {
    return ( function_exists( 'Affiliate_Coupons_Pro') && ! affcoups_is_development() ) ? true : false;
}

/**
 * Get upgrade url
 *
 * @param string $source
 * @param string $medium
 * @return string
 */
function affcoups_get_pro_version_url( $source = '', $medium = '' ) {

    return esc_url( add_query_arg( array(
            'utm_source'   => $source,
            'utm_medium'   => $medium,
            'utm_campaign' => 'Affiliate Coupons',
        ), 'https://affcoups.com/' )
    );
}
