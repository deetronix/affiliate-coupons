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

/**
 * Register new image sizes
 */
function affcoups_add_image_sizes() {
    add_image_size( 'affcoups-thumb', 480, 250, array( 'center', 'center' ) );
    add_image_size( 'affcoups-thumb-small', 144, 75, array( 'center', 'center' ) );
}
add_action( 'init', 'affcoups_add_image_sizes' );

/**
 * Maybe output settings css
 */
function affcoups_maybe_output_settings_css() {

    $settings_css = affcoups_get_settings_css( true );

    // Finished
    if ( ! empty ( $settings_css ) ) {
        echo '<style type="text/css">' . $settings_css . '</style>';
    }
}
add_action( 'wp_head','affcoups_maybe_output_settings_css' );

/**
 * Maybe output custom css
 */
function affcoups_maybe_output_custom_css() {

    $options = affcoups_get_options();

    $custom_css_activated = ( isset( $options['custom_css_activated'] ) && $options['custom_css_activated'] == '1' ) ? true : false;

    if ( $custom_css_activated && ! empty ( $options['custom_css'] ) ) {
        echo '<style type="text/css">' . $options['custom_css'] . '</style>';
    }
}
add_action( 'wp_head','affcoups_maybe_output_custom_css' );

/**
 * Check and embed AMP styles
 *
 * Supported plugins:
 * https://wordpress.org/plugins/amp/
 * https://wordpress.org/plugins/accelerated-mobile-pages/
 * https://codecanyon.net/item/wp-amp-accelerated-mobile-pages-for-wordpress-and-woocommerce/16278608/
 *
 * @since       3.0.0
 * @return      void
 */
function affcoups_print_amp_styles() {

    $options = affcoups_get_options();

    // Stylesheet file CSS
    $stylesheet_css = affcoups_get_amp_styles();

    if ( ! empty( $stylesheet_css ) )
        echo $stylesheet_css;

    // Settings CSS
    $settings_css = affcoups_get_settings_css( false );
    $settings_css = apply_filters( 'affcoups_custom_settings_amp_css', $settings_css );

    if ( ! empty( $settings_css ) )
        echo affcoups_cleanup_css_for_amp( $settings_css );

    // Custom CSS
    $custom_css_activated = ( isset( $options['custom_css_activated'] ) && $options['custom_css_activated'] == '1' ) ? true : false;
    $custom_css = ( isset( $options['custom_css'] ) ) ? $options['custom_css'] : '';

    if ( $custom_css_activated && ! empty( $custom_css ) )
        echo affcoups_cleanup_css_for_amp( $custom_css );
}
add_action( 'amp_post_template_css', 'affcoups_print_amp_styles' ); // AMP, Accelerated Mobile Pages
add_action( 'amphtml_template_css', 'affcoups_print_amp_styles' ); // WP AMP