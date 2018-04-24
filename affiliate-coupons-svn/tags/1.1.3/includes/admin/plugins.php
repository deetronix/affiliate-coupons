<?php
/**
 * Settings
 *
 * @package     AffiliateCoupons\Admin\Plugins
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugins row action links
 *
 * @param array $links already defined action links
 * @param string $file plugin file path and name being processed
 * @return array $links
 */
function affcoups_action_links( $links, $file ) {

    $settings_link = '<a href="' . admin_url( 'edit.php?post_type=affcoups_coupon&page=affcoups_settings' ) . '">' . esc_html__( 'Settings', 'affiliate-coupons' ) . '</a>';

    if ( $file == 'affiliate-coupons/affiliate-coupons.php' )
        array_unshift( $links, $settings_link );

    return $links;
}
add_filter( 'plugin_action_links', 'affcoups_action_links', 10, 2 );

/**
 * Plugin row meta links
 *
 * @param array $input already defined meta links
 * @param string $file plugin file path and name being processed
 * @return array $input
 */
function affcoups_row_meta( $input, $file ) {

    if ( $file != 'affiliate-coupons/affiliate-coupons.php' )
        return $input;

    $custom_link = esc_url( add_query_arg( array(
            'utm_source'   => 'plugins-page',
            'utm_medium'   => 'plugin-row',
            'utm_campaign' => 'Affiliate Coupons',
        ), 'https://wordpress.org/plugins/affiliate-coupons/' )
    );

    $links = array(
        '<a href="' . $custom_link . '">' . esc_html__( 'Example Link', 'affiliate-coupons' ) . '</a>',
    );

    $input = array_merge( $input, $links );

    return $input;
}
//add_filter( 'plugin_row_meta', 'affcoups_row_meta', 10, 2 );