<?php
/**
 * Get template file
 *
 * @param $template
 * @param string $type
 * @return string
 */

function affcoups_get_template_file( $template, $type = '' ) {

    $template_file = AFFCOUPS_DIR . 'templates/' . $template . '.php';

    $template_file = apply_filters( 'affcoups_template_file', $template_file, $template, $type );

    if ( file_exists( $template_file ) ) {
        return $template_file;
    }

    return ( 'widget' === $type ) ? AFFCOUPS_DIR . 'templates/widget.php' : AFFCOUPS_DIR . 'templates/standard.php';
}

/**
 * Template loader
 *
 * @param $template
 */
function affcoups_get_template( $template, $wrap = false ) {

    // Get template file
    $file = affcoups_get_template_file( $template );

    if ( file_exists( $file ) ) {

        if ( $wrap ) {
	        echo esc_attr( '<div class="affcoups">' );
        }

        include $file;

        if ( $wrap ) {
	        echo esc_attr( '</div>' );
        }

    } else {
        echo esc_attr( '<p>' . __( 'Template not found.', 'affiliate-coupons' ) . '</p>' );
    }
}

/**
 * Output template wrapper start html
 */
function affcoups_the_template_wrapper_start() {

    global $affcoups_template_args;

    ?>
    <div class="affcoups">
    <?php
}

/**
 * Output template wrapper end html
 */
function affcoups_the_template_wrapper_end() {

    global $affcoups_template_args;

    ?>
    </div><!-- /.affcoups -->
    <?php
}

/**
 * Coupon Template classes
 *
 * @param $classes
 */
function affcoups_the_coupon_classes( $classes ) {

    global $affcoups_shortcode_atts;
    global $affcoups_template_args;

    $prefix = ' affcoups-coupon--';

    // Templates
    if ( in_array( $affcoups_template_args['template'], array( 'standard', 'grid' ) ) ) {
        $classes .= $prefix . 'standard';
    } else {
        $classes .= $prefix . $affcoups_template_args['template'];
    }

    // Contents
    $coupon_code = affcoups_get_coupon_code();

    if ( $coupon_code )
        $classes .= $prefix . 'code';

    $coupon_discount = affcoups_get_coupon_discount();

    if ( $coupon_discount ) {
        $classes .= $prefix . 'discount';
    }

    // Finally output classes
    echo esc_attr( $classes );
}
