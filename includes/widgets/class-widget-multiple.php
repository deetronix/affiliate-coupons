<?php
/**
 * Widget: Multiple Coupons
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
};

if ( ! class_exists( 'Affcoups_Multiple_Widget' ) ) {

	/**
	 * Adds UFWP_Courses widget.
	 */
	class Affcoups_Multiple_Widget extends WP_Widget {

		protected static $did_script = false;

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'affcoups_multiple_widget', // Base ID
                __( 'Coupons', 'affiliate-coupons' ), // Name
				array( 'description' => __( 'Displays multiple coupons based on different criteria.', 'affiliate-coupons' ), ) // Args
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty( $instance['title'] ) ) {
				echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
			}

			// Category
			if ( ! empty ( $instance['category'] ) ) {
				$shortcode_atts['category'] = $instance['category'];
			}

			// Type
			if ( ! empty ( $instance['type'] ) ) {
				$shortcode_atts['type'] = $instance['type'];
			}

			// Vendor
			if ( ! empty ( $instance['vendor'] ) ) {
				$shortcode_atts['vendor'] = $instance['vendor'];
			}

			// Orderby
			if ( ! empty ( $instance['orderby'] ) ) {
				$shortcode_atts['orderby'] = $instance['orderby'];
			}

			// Order
			if ( ! empty ( $instance['order'] ) ) {
				$shortcode_atts['order'] = $instance['order'];
			}

			// Coupons per Page
			if ( ! empty ( $instance['max'] ) ) {
				$shortcode_atts['max'] = $instance['max'];
			}

			// Template
            $shortcode_atts['template'] = ( ! empty( $instance['template'] ) ) ? $instance['template'] : 'widget';

            // Style
            $shortcode_atts['style'] = ( ! empty( $instance['style'] ) ) ? $instance['style'] : 'standard';

            // Execute Shortcode
			affcoups_widget_do_shortcode( $shortcode_atts );

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

			$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$category = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$type     = ! empty( $instance['type'] ) ? $instance['type'] : '';
			$vendor   = ! empty( $instance['vendor'] ) ? $instance['vendor'] : '';
			$orderby  = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
			$order    = ! empty( $instance['order'] ) ? $instance['order'] : 'rand';
			$max      = ! empty( $instance['max'] ) ? intval( $instance['max'] ) : '3';
			$template = ! empty( $instance['template'] ) ? $instance['template'] : 'widget';
            $style = ! empty( $instance['style'] ) ? $instance['style'] : 'standard';
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
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $category, $key ); ?>><?php echo esc_attr( $label ); ?></option>
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
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $type, $key ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php } ?>
                </select>
            </p>

            <!-- Vendor -->
			<?php
			$vendors = affcoups_get_vendors_list();
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
			$ordersby = affcoups_get_orderby_options();
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
				'ASC'  => __( 'ASC', 'affiliate-coupons' ),
				'DESC' => __( 'DESC', 'affiliate-coupons' ),
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

            <!-- Number of Coupons -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'max' ) ); ?>"><?php esc_attr_e( esc_attr( 'Number of Coupons:' ), 'affiliate-coupons' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'max' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'max' ) ); ?>" type="number" value="<?php echo esc_attr( $max ); ?>">
            </p>

            <!-- Templates -->
			<?php
			$templates = affcoups_get_widget_template_options();
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php esc_attr_e( 'Template:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>">
					<?php foreach ( $templates as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $template, $key ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php } ?>
                </select>
                <br/>
                <small>
					<?php esc_attr_e( 'The templates listed above are optimized for widgets.', 'affiliate-coupons' ); ?>
                </small>
            </p>

            <!-- Styles -->
            <?php
            $styles = affcoups_get_style_options();
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_attr_e( 'Style:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
                    <?php foreach ( $styles as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $style, $key ); ?>><?php echo esc_attr( $label ); ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php affcoups_the_pro_feature_note( __( 'More templates & styles', 'affiliate-coupons' ), false ); ?>
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
			$instance['max']      = ( ! empty( $new_instance['max'] ) ) ? strip_tags( $new_instance['max'] ) : '';
			$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
            $instance['style'] = ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';

			return $instance;
		}
	}

}