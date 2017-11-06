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

    if ( affcoups_has_plugin_content() && $custom_css_activated && ! empty ( $options['custom_css'] ) ) {
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