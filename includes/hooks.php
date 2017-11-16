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
 * Custom CSS
 */
function affcoups_insert_custom_css() {

    $options = affcoups_get_options();

    $custom_css_activated = ( isset( $options['custom_css_activated'] ) && $options['custom_css_activated'] == '1' ) ? true : false;

    if ( $custom_css_activated && ! empty ( $options['custom_css'] ) ) {
        echo '<style type="text/css">' . $options['custom_css'] . '</style>';
    }
}
add_action( 'wp_head','affcoups_insert_custom_css' );

/**
 * Maybe cleanup shortcode output in order to remove empy p/br tags
 *
 * @param $content
 *
 * @return string
 */
function affcoups_maybe_cleanup_shortcode_output( $content ) {

    // array of custom shortcodes requiring the fix
    $block = join("|",array( 'affcoups', 'affcoups_coupons' ) );

    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

    return $rep;
}
//add_filter('the_content', 'affcoups_maybe_cleanup_shortcode_output' );

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

    // Stylesheet file CSS
    $stylesheet_css = affcoups_get_amp_styles();

    if ( ! empty( $stylesheet_css ) )
        echo $stylesheet_css;

    // Custom Settings CSS
    $custom_settings_css = apply_filters( 'affcoups_custom_settings_amp_css', '' );

    if ( ! empty( $custom_settings_css ) )
        echo affcoups_cleanup_css_for_amp( $custom_settings_css );
}
add_action( 'amp_post_template_css', 'affcoups_print_amp_styles' ); // AMP, Accelerated Mobile Pages
add_action( 'amphtml_template_css', 'affcoups_print_amp_styles' ); // WP AMP