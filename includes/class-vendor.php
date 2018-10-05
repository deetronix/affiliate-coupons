<?php
/**
 * Vendor Class
 *
 * @package     AffiliateCoupons\VendorClass
 * @since       1.5.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if (!class_exists('Affcoups_Vendor')) {

    class Affcoups_Vendor
    {
        // General
        public $options;

        // Variables
        public $post; // WP_Post
        public $id;

        /**
         * Affcoups_Vendor constructor.
         * @param $post WP_Post or Post ID
         */
        public function __construct( $post ) {

            if ( is_numeric( $post ) )
                $post = get_post( $post );

            $this->options = affcoups_get_options();

            // Setup
            $this->post = $post;
            $this->id = $post->ID;
        }

        /**
         * Get vendor id
         *
         * @return int
         */
        public function get_id() {
            return $this->id;
        }

        /**
         * Get vendor title
         *
         * @return null|string
         */
        function get_title() {
            return ( ! empty( $this->id ) ) ? get_the_title( $this->id ) : null;
        }

        /**
         * Get vendor url
         *
         * @return bool|mixed
         */
        function get_url() {

            $url = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'vendor_url', true );

            return ( ! empty( $url ) ) ? $url : null;
        }

        /**
         * Get vendor image
         *
         * @param null $size
         * @return bool|mixed
         */
        function get_image( $size = null ) {

            $image_size = ( 'small' === $size ) ? 'affcoups-thumb-small' : 'affcoups-thumb';

            $images = rwmb_meta( AFFCOUPS_PREFIX . 'vendor_image', 'type=image&size=' . $image_size, $this->id );

            return ( ! empty( $images ) && is_array( $images ) ) ? array_shift( $images ) : null;
        }
    }
}