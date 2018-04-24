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

    if ( file_exists( $template_file ) )
        return $template_file;

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

        if ( $wrap )
            echo '<div class="affcoups">';

        include( $file );

        if ( $wrap )
            echo '</div>';

    } else {
        echo '<p>' . __('Template not found.', 'affiliate-coupons') . '</p>';
    }
}