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
add_filter( 'widget_text', 'do_shortcode');

/**
 * Handle shortcode in text widgets
 *
 * @param $widget_text
 * @param $instance
 * @param $widget
 * @return mixed
 */
function affcoups_widget_text( $widget_text, $instance, $widget ) {

    if ( has_shortcode( $instance['text'], 'affcoups' ) ) {

        // Add widget template if missing
        if ( strpos( $instance['text'], 'template') === false ) {
            $widget_text = str_replace( '[affcoups', '[affcoups template="widget"', $widget_text );

        // Reset invalid templates
        } elseif ( strpos( $instance['text'], 'template="standard"') !== false ) {
            $widget_text = str_replace( 'template="standard"', 'template="widget"', $widget_text );

        } elseif ( strpos( $instance['text'], 'template="grid"') !== false ) {
            $widget_text = str_replace( 'template="grid"', 'template="widget"', $widget_text );

        } elseif ( strpos( $instance['text'], 'template="list"') !== false ) {
            $widget_text = str_replace( 'template="list"', 'template="widget"', $widget_text );
        }
    }

    // Todo: Cleanup empty p & breaks here too

    return $widget_text;
}
add_filter( 'widget_text', 'affcoups_widget_text', 1, 3 );