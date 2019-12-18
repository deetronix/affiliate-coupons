<?php
/**
 * Vendor post type
 *
 * @package     AffiliateCoupons\Vendors\PostType
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register Custom Post Type
 */
function affcoups_register_vendor_post_type() {

	$labels = array(
		'name'                  => _x( 'Vendors', 'Post Type General Name', 'affiliate-coupons' ),
		'singular_name'         => _x( 'Vendor', 'Post Type Singular Name', 'affiliate-coupons' ),
		'menu_name'             => __( 'Vendors', 'affiliate-coupons' ),
		'name_admin_bar'        => __( 'Vendor', 'affiliate-coupons' ),
		'archives'              => __( 'Vendor Archives', 'affiliate-coupons' ),
		'parent_item_colon'     => __( 'Parent Vendor:', 'affiliate-coupons' ),
		'all_items'             => __( 'Vendors', 'affiliate-coupons' ), // Submenu name
		'add_new_item'          => __( 'Add New Vendor', 'affiliate-coupons' ),
		'add_new'               => __( 'Add Vendor', 'affiliate-coupons' ),
		'new_item'              => __( 'New Vendor', 'affiliate-coupons' ),
		'edit_item'             => __( 'Edit Vendor', 'affiliate-coupons' ),
		'update_item'           => __( 'Update Vendor', 'affiliate-coupons' ),
		'view_item'             => __( 'View Vendor', 'affiliate-coupons' ),
		'search_items'          => __( 'Search Vendor', 'affiliate-coupons' ),
		'not_found'             => __( 'Not found', 'affiliate-coupons' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'affiliate-coupons' ),
		'featured_image'        => __( 'Featured Image', 'affiliate-coupons' ),
		'set_featured_image'    => __( 'Set featured image', 'affiliate-coupons' ),
		'remove_featured_image' => __( 'Remove featured image', 'affiliate-coupons' ),
		'use_featured_image'    => __( 'Use as featured image', 'affiliate-coupons' ),
		'insert_into_item'      => __( 'Insert into vendor', 'affiliate-coupons' ),
		'uploaded_to_this_item' => __( 'Uploaded to this vendor', 'affiliate-coupons' ),
		'items_list'            => __( 'Vendors list', 'affiliate-coupons' ),
		'items_list_navigation' => __( 'Vendors list navigation', 'affiliate-coupons' ),
		'filter_items_list'     => __( 'Filter vendors list', 'affiliate-coupons' ),
	);

	if ( is_admin() && isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/wp-admin/export.php' ) !== false ) {
		$labels['name'] = _x( 'Affiliate Coupons - Vendors', 'Post Type General Name (Export)', 'affiliate-coupons' );
	}

	$args = array(
		'label'               => __( 'Vendor', 'affiliate-coupons' ),
		'description'         => __( 'Vendors', 'affiliate-coupons' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=' . AFFCOUPS_COUPON_POST_TYPE,
		'menu_position'       => 25,
		'menu_icon'           => false,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);
	register_post_type( AFFCOUPS_VENDOR_POST_TYPE, $args );
}
add_action( 'init', 'affcoups_register_vendor_post_type', 0 );
