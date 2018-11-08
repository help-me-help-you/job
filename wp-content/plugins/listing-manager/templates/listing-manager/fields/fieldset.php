<div class="listing-manager-submission-fieldset-wrapper">
    <div class="listing-manager-submission-fieldset listing-manager-submission-form-<?php echo esc_attr( $id ); ?><?php if ( ! empty( $collapsible ) ) : ?> collapsible<?php endif; ?>">
        <?php if ( ! empty( $legend ) ) : ?>
            <div class="fieldset-legend">
                <?php echo wp_kses( $legend, wp_kses_allowed_html('post') ); ?>
            </div><!-- /.fieldset-legend -->
        <?php endif; ?>

        <div class="fieldset-content">
            <?php echo $content; ?>
        </div><!-- /.fieldset-content -->
    </div>
</div><!-- /.listing-manager-submission-fieldset-wrapper -->