<?php
/**
 * Template for generating output for list view
 */

if ( ! isset( $coupons ) ) {
    return;
}

?>
<?php affcoups_the_template_wrapper_start(); ?>

    <div class="affcoups-coupons-list">

        <?php while ( $coupons->have_posts() ) { ?>
            <?php $coupons->the_post(); ?>

            <div class="<?php affcoups_the_coupon_classes('affcoups-coupon'); ?>">

                <?php if ( affcoups_get_coupon_discount() ) { ?>
                    <span class="affcoups-coupon__discount"><?php echo esc_attr( affcoups_get_coupon_discount() ); ?></span>
                <?php } ?>

                <div class="affcoups-coupon__header">
                    <?php affcoups_the_coupon_thumbnail(); ?>

                    <?php if ( affcoups_get_coupon_types() ) { ?>
                        <div class="affcoups-coupon__types">
                            <?php affcoups_the_coupon_types(); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="affcoups-coupon__content">
                    <h3 class="affcoups-coupon__title"><?php echo esc_attr( affcoups_get_coupon_title() ); ?></h3>

                    <div class="affcoups-coupon__description">

                        <div class="affcoups-coupon__description-excerpt">
                            <?php affcoups_the_coupon_excerpt(); ?>
                        </div>
                        <div class="affcoups-coupon__description-full">
                            <?php echo wp_kses_post( affcoups_get_coupon_description() ); ?>
                            <a href="#" class="affcoups-toggle-desc" data-affcoups-toggle-desc="true">Less</a>
                        </div>
                    </div>

                </div>

                <div class="affcoups-coupon__footer">

                    <?php if ( affcoups_get_coupon_code() ) { ?>
                        <div class="affcoups-coupon__code">
                            <?php affcoups_the_coupon_code(); ?>
                        </div>
                    <?php } ?>

                    <?php affcoups_the_coupon_button(); ?>

                    <?php if ( affcoups_coupon_has_valid_dates() ) { ?>
                        <div class="affcoups-coupon__valid-dates">
                            <?php affcoups_the_coupon_valid_dates(); ?>
                        </div>
                    <?php } ?>
                </div>

            </div>
        <?php } ?>

    </div>

<?php affcoups_the_template_wrapper_end(); ?>
