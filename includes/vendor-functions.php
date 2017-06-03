<?php
/**
 * Vendor functions
 *
 * @package     AffiliateCoupons\VendorFunctions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function affcoups_get_vendor_url( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $url = get_post_meta( $postid, AFFCOUPS_PREFIX . 'vendor_url', true );

    return ( ! empty ( $url ) ) ? $url : false;
}

function affcoups_get_vendor_thumbnail( $postid = null, $size = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    // Get thumbnail from coupon
    $image_size = ( 'small' === $size ) ? 'affcoups-thumb-small' : 'affcoups-thumb';

    $images = rwmb_meta( AFFCOUPS_PREFIX . 'vendor_image', 'type=image&size=' . $image_size, $postid );

    if ( ! empty ( $images ) && is_array( $images ) )
        return array_shift( $images );

    // No thumbnail found
    return false;
}