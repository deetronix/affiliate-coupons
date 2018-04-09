<?php
if ( ! isset( $coupons ) ) {
    return;
}

// Default values
if ( ! isset ( $grid ) )
    $grid = '3';
?>
<?php affcoups_the_template_wrapper_start(); ?>

    <div class="affcoups-coupons-grid affcoups-coupons-grid--col-<?php echo $grid; ?>">

        <?php while ( $coupons->have_posts() ) { ?>
            <?php $coupons->the_post(); ?>

            <div class="affcoups-coupons-grid__item">

                <div class="<?php affcoups_the_coupon_classes('affcoups-coupon'); ?>">
                    <div class="affcoups-coupon__header">
                        <?php affcoups_the_coupon_thumbnail(); ?>

                        <?php if ( affcoups_get_coupon_discount() ) { ?>
                            <span class="affcoups-coupon__discount"><?php echo affcoups_get_coupon_discount(); ?></span>
                        <?php } ?>
                    </div>

                    <div class="affcoups-coupon__content">
                        <h3 class="affcoups-coupon__title"><?php echo affcoups_get_coupon_title(); ?></h3>

                        <?php if ( affcoups_get_coupon_types() ) { ?>
                            <div class="affcoups-coupon__types">
                                <?php affcoups_the_coupon_types(); ?>
                            </div>
                        <?php } ?>

                        <div class="affcoups-coupon__description">
                            <?php echo affcoups_get_coupon_description(); ?>
                        </div>

                        <?php if ( affcoups_get_coupon_code() ) { ?>
                            <div class="affcoups-coupon__code">
                                <?php affcoups_the_coupon_code(); ?>
                            </div>
                        <?php } ?>

                        <?php if ( affcoups_coupon_has_valid_dates() ) { ?>
                            <div class="affcoups-coupon__valid-dates">
                                <?php affcoups_the_coupon_valid_dates(); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="affcoups-coupon__footer">
                        <?php affcoups_the_coupon_button(); ?>
                    </div>

                </div>

            </div>
        <?php } ?>
    </div>

<?php affcoups_the_template_wrapper_end(); ?>
