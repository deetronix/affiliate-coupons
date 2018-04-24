<?php
/**
 * Metaboxes
 *
 * @package     AffiliateCoupons\Vendors\Metaboxes
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Add Metaboxes
 */
function affcoups_register_vendor_meta_boxes( $meta_boxes ) {

    $fields = array(
        array(
            'name'             => esc_html__( 'Image', 'affiliate-coupons' ),
            'id'               => AFFILIATE_COUPONS_PREFIX . 'vendor_image',
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
        ),
        array(
            'name' => esc_html__( 'URL', 'affiliate-coupons' ),
            'id'   => AFFILIATE_COUPONS_PREFIX . 'vendor_url',
            'desc' => esc_html__( 'This will be the default url of the selected vendor or its coupons.', 'affiliate-coupons' ),
            'type' => 'url'
        ),
        array(
            'name' => esc_html__( 'Description', 'affiliate-coupons' ),
            'id'   => AFFILIATE_COUPONS_PREFIX . 'vendor_description',
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 3,
        ),
    );

    $fields = apply_filters( 'affcoups_vendor_details_meta_fields', $fields );

    $meta_boxes[] = array(
        'id'         => AFFILIATE_COUPONS_PREFIX . 'vendor_details',
        'title'      => __( 'Vendor: Details', 'affiliate-coupons' ),
        'post_types' => array( 'affcoups_vendor' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'fields' => $fields
    );

    $meta_boxes = apply_filters( 'affcoups_vendor_meta_boxes', $meta_boxes );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'affcoups_register_vendor_meta_boxes' );