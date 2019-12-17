<?php
/**
 * Type Taxonomy
 *
 * @package     AffiliateCoupons\Coupons\TypeTaxonomy
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register Custom Taxonomy
 */
function affcoups_register_coupon_type_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'affiliate-coupons' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'affiliate-coupons' ),
		'menu_name'                  => __( 'Types', 'affiliate-coupons' ),
		'all_items'                  => __( 'All Types', 'affiliate-coupons' ),
		'parent_item'                => __( 'Parent Type', 'affiliate-coupons' ),
		'parent_item_colon'          => __( 'Parent Type:', 'affiliate-coupons' ),
		'new_item_name'              => __( 'New Type Name', 'affiliate-coupons' ),
		'add_new_item'               => __( 'Add New Type', 'affiliate-coupons' ),
		'edit_item'                  => __( 'Edit Type', 'affiliate-coupons' ),
		'update_item'                => __( 'Update Type', 'affiliate-coupons' ),
		'view_item'                  => __( 'View Type', 'affiliate-coupons' ),
		'separate_items_with_commas' => __( 'Separate types with commas', 'affiliate-coupons' ),
		'add_or_remove_items'        => __( 'Add or remove types', 'affiliate-coupons' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'affiliate-coupons' ),
		'popular_items'              => __( 'Popular Types', 'affiliate-coupons' ),
		'search_items'               => __( 'Search Types', 'affiliate-coupons' ),
		'not_found'                  => __( 'Not Found', 'affiliate-coupons' ),
		'no_terms'                   => __( 'No types', 'affiliate-coupons' ),
		'items_list'                 => __( 'Types list', 'affiliate-coupons' ),
		'items_list_navigation'      => __( 'Types list navigation', 'affiliate-coupons' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
        'show_in_rest'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'rewrite'           => false,
	);

	$args = apply_filters( 'affcoups_coupon_type_taxonomy_args', $args );

	register_taxonomy( AFFCOUPS_COUPON_TYPE_TAXONOMY, array( AFFCOUPS_COUPON_POST_TYPE ), $args );
}
add_action( 'init', 'affcoups_register_coupon_type_taxonomy', 0 );
