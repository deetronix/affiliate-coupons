<?php
/**
 * Widget: Multible Coupons
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
};

if ( ! class_exists( 'Affcoups_Multible_Widget' ) ) {

    /**
     * Adds UFWP_Courses widget.
     */
    class Affcoups_Multible_Widget extends WP_Widget {

        protected static $did_script = false;

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            parent::__construct(
                'affcoups_multible_widget', // Base ID
                'Affiliate Coupons - ' . __( 'Multible Coupons', 'affiliate-coupons' ), // Name
                array( 'description' => __( 'Displaying coupons by their category.', 'affiliate-coupons' ), ) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {

            echo wp_kses_post( $args['before_widget'] );

            if ( ! empty( $instance['title'] ) ) {
                echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
            }

            if ( ! empty ( $instance['category'] ) ) {

                // Category
                $shortcode_atts = array(
                    'category' => $instance['category'],
                );
	            
	            // Type
	            if ( ! empty ( $instance['type'] ) ) {
		            $shortcode_atts['type'] = $instance['type'];
	            }
	
	            // Vendor
	            if ( ! empty ( $instance['vendor'] ) ) {
		            $shortcode_atts['vendor'] = $instance['vendor'];
	            }
	            
	            // Orderby
	            $shortcode_atts['orderby'] = $instance['orderby'];
	
	            // Order
	            $shortcode_atts['order'] = $instance['order'];

                // Template
                $shortcode_atts['template'] = $instance['template'];

                // Execute Shortcode
                affcoups_widget_do_shortcode( $shortcode_atts );

            } else {
	            echo esc_attr( 'Please select a category.', 'affiliate-coupons' );
            }

            echo wp_kses_post( $args['after_widget'] );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {
         
	        //affcoups_debug($categories);
            
            $title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $category = ! empty( $instance['category'] ) ? $instance['category'] : '';
	        $type     = ! empty( $instance['type'] ) ? $instance['type'] : '';
	        $vendor   = ! empty( $instance['vendor'] ) ? $instance['vendor'] : '';
	        $orderby  = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
	        $order    = ! empty( $instance['order'] ) ? $instance['order'] : '';
            $template = ! empty( $instance['template'] ) ? $instance['template'] : 'widget';

            ?>
            <!-- Title -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( esc_attr( 'Title:' ), 'affiliate-coupons' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>

            <!-- Categories -->
            <?php
	        $categories = affcoups_get_category_taxonomy();
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_attr_e( 'Coupon Category:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
                    <?php foreach ( $categories as $key => $label ) { ?>
                        <option value="" disabled selected><?php esc_attr_e( 'Please select...', 'affiliate-coupons' ); ?></option>
                        <option value="<?php echo esc_attr( $label->name ); ?>" <?php selected( $category, $key ); ?>><?php echo esc_attr( $label->name ); ?></option>
                    <?php } ?>
                </select>
            </p>

            <!-- Types -->
	        <?php
	        $types = affcoups_get_types_taxonomy();
	        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_attr_e( 'Coupon Type:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
			        <?php foreach ( $types as $key => $label ) { ?>
                        <option value="" disabled selected><?php esc_attr_e( 'Please select...', 'affiliate-coupons' ); ?></option>
                        <option value="<?php echo esc_attr( $label->name ); ?>" <?php selected( $type, $key ); ?>><?php echo esc_attr( $label->name ); ?></option>
			        <?php } ?>
                </select>
            </p>

            <!-- Vendor -->
	        <?php
	        $vendors = affcoups_get_vendors_list();
	        //affcoups_debug($vendors);
	        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_attr_e( 'Coupon Vendor:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vendor' ) ); ?>">
			        <?php foreach ( $vendors as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $vendor, $key ); ?>><?php echo esc_attr( $label ); ?></option>
			        <?php } ?>
                </select>
            </p>

            <!-- Orderby -->
	        <?php
	        $ordersby = array(
		        'date'   => __( 'Date', 'affiliate-coupons' ),
		        'name'   => __( 'Name', 'affiliate-coupons' ),
		        'author' => __( 'Author', 'affiliate-coupons' ),
	        );
	        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_attr_e( 'Order by:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
			        <?php foreach ( $ordersby as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $orderby, $key ); ?>><?php echo esc_attr( $label ); ?></option>
			        <?php } ?>
                </select>
            </p>

            <!-- Order -->
	        <?php
	        $orders = array(
		        'ASC'   => __( 'ASC', 'affiliate-coupons' ),
		        'DESC'   => __( 'DESC', 'affiliate-coupons' ),
	        );
	        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_attr_e( 'Order:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
			        <?php foreach ( $orders as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $order, $key ); ?>><?php echo esc_attr( $label ); ?></option>
			        <?php } ?>
                </select>
            </p>

            <!-- Template -->
            <?php
            $templates = array(
	            'widget' => __( 'Standard', 'affiliate-coupons' ),
            );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php esc_attr_e( 'Template:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>">
                    <?php foreach ( $templates as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $template, $key ); ?>><?php echo esc_attr( $label ); ?></option>
                    <?php } ?>
                </select>
                <br />
                <small>
                    <?php esc_attr_e( 'The templates listed above are optimized for widgets.', 'affiliate-coupons' ); ?>
                </small>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();

            $instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
	        $instance['type']     = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
	        $instance['vendor']   = ( ! empty( $new_instance['vendor'] ) ) ? strip_tags( $new_instance['vendor'] ) : '';
	        $instance['orderby']  = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
	        $instance['order']    = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
	        $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';

            return $instance;
        }
    }

}