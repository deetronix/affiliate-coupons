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
	add_image_size( 'affcoups-thumb', 480, 270, array( 'center', 'center' ) );
	add_image_size( 'affcoups-thumb-small', 133, 75, array( 'center', 'center' ) );
}

add_action( 'init', 'affcoups_add_image_sizes' );

/**
 * Maybe output settings css
 */
function affcoups_maybe_output_settings_css() {

	$settings_css = affcoups_get_settings_css( true );

	// Finished
	if ( ! empty( $settings_css ) ) {
		echo '<style type="text/css">' . $settings_css . '</style>';
	};
}
add_action( 'wp_head', 'affcoups_maybe_output_settings_css', 10 );

/**
 * Maybe output custom css
 */
function affcoups_maybe_output_custom_css() {

	$options = affcoups_get_options();

	$custom_css_activated = ( isset( $options['custom_css_activated'] ) && '1' === $options['custom_css_activated'] ) ? true : false;

	if ( $custom_css_activated && ! empty( $options['custom_css'] ) ) {
		echo '<style type="text/css">' . $options['custom_css'] . '</style>';
	};
}
add_action( 'wp_head', 'affcoups_maybe_output_custom_css' );

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

	if ( ! empty( $stylesheet_css ) ) {
		echo $stylesheet_css;
	}

	// Settings CSS
	$settings_css = affcoups_get_settings_css( false );
	$settings_css = apply_filters( 'affcoups_custom_settings_amp_css', $settings_css );

	if ( ! empty( $settings_css ) ) {
		echo affcoups_cleanup_css_for_amp( $settings_css );
	}

	echo affcoups_cleanup_css_for_amp( $settings_css );

	// Custom CSS
	$custom_css_activated = ( isset( $options['custom_css_activated'] ) && '1' === $options['custom_css_activated'] ) ? true : false;
	$custom_css           = ( isset( $options['custom_css'] ) ) ? $options['custom_css'] : '';

	if ( $custom_css_activated && ! empty( $custom_css ) ) {
		echo affcoups_cleanup_css_for_amp( $custom_css );
	}
}

add_action( 'amp_post_template_css', 'affcoups_print_amp_styles' ); // AMP, Accelerated Mobile Pages
add_action( 'amphtml_template_css', 'affcoups_print_amp_styles' ); // WP AMP

/**
 * Handle coupon additional classes
 *
 * @param $add_classes
 * @param Affcoups_Coupon $Coupon
 * @return mixed
 */
function affcoups_coupon_add_classes( $add_classes, $Coupon ) {

    // Check shortcode atts
    global $affcoups_template_args;

    // Floats
    if ( isset( $affcoups_template_args['float'] ) )
        $add_classes[] = 'float-' . esc_html( $affcoups_template_args['float'] );

    // Styles
    if ( isset( $affcoups_template_args['style'] ) ) {
        $add_classes[] = 'style-' . esc_html( $affcoups_template_args['style'] );
    }

    // Return
    return $add_classes;
}
add_filter( 'affcoups_coupon_add_classes', 'affcoups_coupon_add_classes', 10, 3 );

/**
 * Maybe output frontend variables
 */
function affcoups_frontend_variables() {

    $vars = array();

    $vars = apply_filters( 'affcoups_frontend_vars', $vars );

    if ( ! is_array( $vars ) || sizeof( $vars ) === 0 )
        return;
    ?>
    <script type="text/javascript">
        /* <![CDATA[ */
        var affcoups_vars = <?php echo json_encode( $vars ); ?>;
        /* ]]> */
    </script>
    <?php
}
add_action( 'wp_footer', 'affcoups_frontend_variables' );

/**
 * Maybe show plugin credits
 *
 * @param $output
 * @param $is_widget
 * @return string
 */
function affcoups_maybe_show_credits( $output, $is_widget ) {

    $show_credits = affcoups_get_option( 'show_credits' );

    if ( ! empty ( $show_credits ) && ! $is_widget ) {

        $url = esc_url( add_query_arg( array(
                'utm_source'   => get_bloginfo( 'title' ),
                'utm_medium'   => 'credits-link',
                'utm_campaign' => 'Affiliate Coupons',
            ), 'https://affcoups.com' )
        );

        $output .= '<p class="affcoups-credits">' . sprintf( wp_kses( __( 'Made with the <a href="%s" target="_blank" rel="nofollow">Affiliate Coupons</a> WordPress plugin.', 'affiliate-coupons' ), array(  'a' => array( 'href' => array(), 'target' => '_blank', 'rel' => 'nofollow' ) ) ), esc_url( $url ) ) . '</p>';
    }

    return $output;
}
add_filter( 'affcoups_shortcode_output', 'affcoups_maybe_show_credits', 99, 2 );