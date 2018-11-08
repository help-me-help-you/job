<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['classes'] ) ) : ?>
<div class="<?php echo esc_attr( $instance['classes'] ); ?>">
	<?php endif; ?>

    <div class="listing-manager-cta-wrapper">
        <div class="listing-manager-cta">
            <div class="listing-manager-cta-content">
                <?php if ( ! empty( $instance['image'] ) ) : ?>
                    <div class="listing-manager-cta-image">
                        <div class="listing-manager-cta-image-inner" style="background-image: url(<?php echo esc_attr( $instance['image'] ); ?>);">
                        </div>
                    </div><!-- /.listing-manager-cta-image -->
                <?php endif; ?>

                <div class="listing-manager-cta-content-inner">
                    <div class="listing-manager-cta-content-body">
                        <?php if ( ! empty( $instance['title'] ) ) : ?>
                            <div class="listing-manager-cta-title">
                                <?php echo esc_html( $instance['title'] ); ?>
                            </div><!-- /.listing-manager-cta-title -->
                        <?php endif; ?>

                        <?php if ( ! empty( $instance['description'] ) ) : ?>
                            <div class="listing-manager-cta-description">
                                <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
                            </div><!-- /.listing-manager-cta-description -->
                        <?php endif; ?>
                    </div><!-- /.listing-manager-cta-content-body -->

	                <?php if ( ! empty( $instance['action_link'] ) && ! empty( $instance['action_title'] ) ) : ?>
                        <div class="listing-manager-cta-action">
                            <a href="<?php echo esc_html( $instance['action_link'] ); ?>">
				                <?php echo esc_html( $instance['action_title'] ); ?>
                            </a>
                        </div><!-- /.listing-manager-cta-action -->
	                <?php endif; ?>
                </div><!-- /.listing-manager-cta-content-inner -->
            </div><!-- /.listing-manager-cta-content -->
        </div><!-- /.listing-manager-cta -->
    </div><!-- /.listing-manager-cta-wrapper -->
	<?php if ( ! empty( $instance['classes'] ) ) : ?>
</div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
