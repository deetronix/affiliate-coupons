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
 * Get upgrade url
 *
 * @param string $source
 * @param string $medium
 * @return string
 */
function affcoups_get_pro_version_url( $source = '', $medium = '' ) {

    return esc_url( add_query_arg( array(
            'utm_source'   => $source,
            'utm_medium'   => $medium,
            'utm_campaign' => 'Affiliate Coupons',
        ), 'https://affcoups.com/' )
    );
}

/**
 * Output the pro feature note
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
                printf( wp_kses( __( ' is available in <a href="%s" target="_blank" rel="nofollow">Affiliate Coupons (PRO)</a>', 'affiliate-coupon' ), array(  'a' => array( 'href' => array(), 'target' => array( '_blank' ), 'rel' => array( 'nofollow' ) ) ) ), esc_url( affcoups_get_pro_version_url() ) );
            } else {
                printf( wp_kses( __( ' are available in <a href="%s" target="_blank" rel="nofollow">Affiliate Coupons (PRO)</a>', 'affiliate-coupon' ), array(  'a' => array( 'href' => array(), 'target' => array( '_blank' ), 'rel' => array( 'nofollow' ) ) ) ), esc_url( affcoups_get_pro_version_url() ) );
            } ?>
        </span>
    </p>
    <?php
}