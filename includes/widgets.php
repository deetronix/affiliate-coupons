<?php
/**
 * Widgets
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Widgets
 */
include_once AFFCOUPS_DIR . 'includes/widgets/class.widget-single.php';

/**
 * Register Widgets
 */
function affcoups_register_widgets() {
    register_widget( 'Affcoups_Single_Widget' );

    do_action('affcoups_register_widgets' );
}
add_action( 'widgets_init', 'affcoups_register_widgets' );

/**
 * Build shortcode
 *
 * @param array $atts
 */
function affcoups_widget_do_shortcode( $atts = array() ) {

    if ( sizeof( $atts ) > 0 ) {

        // Build Shortcode
        $shortcode = '[affcoups';

        foreach ( $atts as $key => $value ) {
            $shortcode .= ' ' . $key . '="' . $value . '"';
        }

        $shortcode .= '/]';

        // Execute Shortcode
        echo do_shortcode( $shortcode );

    } else {
        _e( 'Shortcode arguments missing.', 'affiliate-coupons' );
    }
}

/**
 * Execute shortcodes within text widgets
 */
add_filter( 'widget_text', 'do_shortcode' );