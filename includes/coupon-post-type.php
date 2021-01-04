<?php
/**
 * Coupon post type
 *
 * @package     AffiliateCoupons\Coupons\PostType
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * egister Custom Post Type
 */
function affcoups_register_coupon_post_type() {

	$labels = array(
		'name'                  => _x( 'Coupons', 'Post Type General Name', 'affiliate-coupons' ),
		'singular_name'         => _x( 'Coupon', 'Post Type Singular Name', 'affiliate-coupons' ),
		'menu_name'             => __( 'Affiliate Coupons', 'affiliate-coupons' ),
		'name_admin_bar'        => __( 'Coupon', 'affiliate-coupons' ),
		'archives'              => __( 'Coupon Archives', 'affiliate-coupons' ),
		'parent_item_colon'     => __( 'Parent Coupon:', 'affiliate-coupons' ),
		'all_items'             => __( 'All Coupons', 'affiliate-coupons' ),
		'add_new_item'          => __( 'Add New Coupon', 'affiliate-coupons' ),
		'add_new'               => __( 'Add Coupon', 'affiliate-coupons' ),
		'new_item'              => __( 'New Coupon', 'affiliate-coupons' ),
		'edit_item'             => __( 'Edit Coupon', 'affiliate-coupons' ),
		'update_item'           => __( 'Update Coupon', 'affiliate-coupons' ),
		'view_item'             => __( 'View Coupon', 'affiliate-coupons' ),
		'search_items'          => __( 'Search Coupon', 'affiliate-coupons' ),
		'not_found'             => __( 'Not found', 'affiliate-coupons' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'affiliate-coupons' ),
		'featured_image'        => __( 'Featured Image', 'affiliate-coupons' ),
		'set_featured_image'    => __( 'Set featured image', 'affiliate-coupons' ),
		'remove_featured_image' => __( 'Remove featured image', 'affiliate-coupons' ),
		'use_featured_image'    => __( 'Use as featured image', 'affiliate-coupons' ),
		'insert_into_item'      => __( 'Insert into coupon', 'affiliate-coupons' ),
		'uploaded_to_this_item' => __( 'Uploaded to this coupon', 'affiliate-coupons' ),
		'items_list'            => __( 'Coupons list', 'affiliate-coupons' ),
		'items_list_navigation' => __( 'Coupons list navigation', 'affiliate-coupons' ),
		'filter_items_list'     => __( 'Filter coupons list', 'affiliate-coupons' ),
	);

	if ( is_admin() && isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/wp-admin/export.php' ) !== false ) {
		$labels['name'] = _x( 'Affiliate Coupons - Coupons', 'Post Type General Name (Export)', 'affiliate-coupons' );
	}

	$args = array(
		'label'               => __( 'Coupon', 'affiliate-coupons' ),
		'description'         => __( 'Coupons', 'affiliate-coupons' ),
		'labels'              => $labels,
		'supports'            => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'revisions',
			'page-attributes'
		),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => affcoups_get_assets_url() . 'img/icon-menu.png',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
        'show_in_rest'        => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);

	$args = apply_filters( 'affcoups_coupon_post_type_args', $args );

	register_post_type( AFFCOUPS_COUPON_POST_TYPE, $args );
}
add_action( 'init', 'affcoups_register_coupon_post_type', 0 );

