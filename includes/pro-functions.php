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
 * Get pro version site url
 *
 * @param string $page
 * @param string $source
 * @param string $medium
 * @return string
 */
function affcoups_get_pro_version_url( $page = '', $source = '', $medium = '' ) {

    $url = 'https://affcoups.com/';

    if ( ! empty ( $page ) )
        $url .= trailingslashit( ltrim( $page ) );

    $url = esc_url( add_query_arg( array(
            'utm_source'   => $source,
            'utm_medium'   => $medium,
            'utm_campaign' => 'Affiliate Coupons',
        ), $url )
    );

    return $url;
}

/**
 * Outputs the pro feature note
 *
 * @param $feature
 * @param bool $singular
 */
function affcoups_the_pro_feature_note( $feature, $singular = true ) {

    if ( affcoups_is_pro_version() )
        return;
    ?>
    <p class="affcoups-pro-feature">
        <span class="affcoups-pro-feature__badge">Pro Feature</span>
        <span class="affcoups-pro-feature__text">
            <?php
            echo '<strong>' . esc_html( $feature ) . '</strong>';

            if ( $singular ) {
                printf( wp_kses( __( ' is available in <a href="%s" target="_blank" rel="nofollow">Affiliate Coupons (PRO)</a>', 'affiliate-coupon' ), array(  'a' => array( 'href' => array(), 'target' => array( '_blank' ), 'rel' => array( 'nofollow' ) ) ) ), esc_url( affcoups_get_pro_version_url( 'features' ) ) );
            } else {
                printf( wp_kses( __( ' are available in <a href="%s" target="_blank" rel="nofollow">Affiliate Coupons (PRO)</a>', 'affiliate-coupon' ), array(  'a' => array( 'href' => array(), 'target' => array( '_blank' ), 'rel' => array( 'nofollow' ) ) ) ), esc_url( affcoups_get_pro_version_url( 'features') ) );
            } ?>
        </span>
    </p>
    <?php
}

/**
 * Outputs the pro features tablenav note
 */
function affcoups_the_pro_features_tablenav_note() {

    if ( affcoups_is_pro_version() )
        return;

    $pro_features_link = affcoups_get_pro_version_url( 'features', 'posts-tablenav', 'note' );

    echo '<span class="affcoups-tablenav-note">';
    printf( wp_kses( __( 'Do you already know the pro version of Affiliate Coupons? <a href="%s" target="_blank" rel="nofollow">Discover all the additional features</a>.', 'affiliate-coupons' ), array(  'a' => array( 'href' => array(), 'target' => '_blank', 'rel' => 'nofollow' ) ) ), esc_url( $pro_features_link ) );
    echo '<span>';
}