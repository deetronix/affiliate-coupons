<?php
/**
 * Category Taxonomy
 *
 * @package     AffiliateCoupons\Coupons\CategoryTaxonomy
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register Custom Taxonomy
 */
function affcoups_register_coupon_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'affiliate-coupons' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'affiliate-coupons' ),
		'menu_name'                  => __( 'Categories', 'affiliate-coupons' ),
		'all_items'                  => __( 'All Categories', 'affiliate-coupons' ),
		'parent_item'                => __( 'Parent Category', 'affiliate-coupons' ),
		'parent_item_colon'          => __( 'Parent Category:', 'affiliate-coupons' ),
		'new_item_name'              => __( 'New Category Name', 'affiliate-coupons' ),
		'add_new_item'               => __( 'Add New Category', 'affiliate-coupons' ),
		'edit_item'                  => __( 'Edit Category', 'affiliate-coupons' ),
		'update_item'                => __( 'Update Category', 'affiliate-coupons' ),
		'view_item'                  => __( 'View Category', 'affiliate-coupons' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'affiliate-coupons' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'affiliate-coupons' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'affiliate-coupons' ),
		'popular_items'              => __( 'Popular Categories', 'affiliate-coupons' ),
		'search_items'               => __( 'Search Categories', 'affiliate-coupons' ),
		'not_found'                  => __( 'Not Found', 'affiliate-coupons' ),
		'no_terms'                   => __( 'No categories', 'affiliate-coupons' ),
		'items_list'                 => __( 'Categories list', 'affiliate-coupons' ),
		'items_list_navigation'      => __( 'Categories list navigation', 'affiliate-coupons' ),
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

	register_taxonomy( AFFCOUPS_COUPON_CATEGORY_TAXONOMY, array( AFFCOUPS_COUPON_POST_TYPE ), $args );
}
add_action( 'init', 'affcoups_register_coupon_category_taxonomy', 0 );
