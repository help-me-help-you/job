<?php $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null ); ?>
<?php if ( empty( $api_key) ) : ?>
    <p><?php echo esc_html__( 'Google Maps API key missing.', 'listing-manager' ); ?></p>
<?php else: ?>
    <div class="listing-manager-google-map-search" id="<?php echo esc_attr( $id ); ?>" style="height: 400px;">
    </div><!-- /.listing-manager-google-map-search -->
<?php endif; ?>

<p class="form-group">
	<?php $value = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $id  . '_search', true ) : null; ?>
    <label for="<?php echo esc_attr( $id ); ?>_search"><?php echo esc_html__( 'Search', 'listing-manager' ); ?></label>

    <input type="text" value="<?php echo esc_attr( $value ); ?>"name="<?php echo esc_attr( $id ); ?>_search" class="form-control <?php echo esc_attr( $id ); ?>_search" id="<?php echo esc_attr( $id ); ?>_search">
</p>

<div class="listing-manager-google-map-fields">
    <div class="form-group <?php if ( ! empty( $_SESSION['form_errors'][ $id . '_latitude'] ) ) : ?>form-error<?php endif; ?>">
        <?php $value = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $id  . '_latitude', true ) : null; ?>

        <label for="<?php echo esc_attr( $id ); ?>_latitude">
            <?php echo esc_html__( 'Latitude', 'listing-manager' ); ?>
            <?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
        </label>

        <input type="text"
               <?php if ( $required ) : ?>required="required"<?php endif; ?>
               id="<?php echo esc_attr( $id ); ?>_latitude"
               name="<?php echo esc_attr( $id ); ?>_latitude"
               value="<?php if ( ! empty( $value ) ) : ?><?php echo esc_html( $value ); ?><?php endif; ?>"
               class="form-control">

        <?php if ( ! empty( $_SESSION['form_errors'][ $id . '_latitude' ] ) ) : ?>
            <div class="form-error">
                <?php foreach( $_SESSION['form_errors'][ $id . '_latitude' ] as $message ) : ?>
                    <p><?php echo esc_html( $message ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div><!-- /.form-group -->

    <div class="form-group <?php if ( ! empty( $_SESSION['form_errors'][ $id . '_longitude'] ) ) : ?>form-error<?php endif; ?>">
        <?php $value = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $id  . '_longitude', true ) : null; ?>

        <label for="<?php echo esc_attr( $id ); ?>_longitude">
            <?php echo esc_html__( 'Longitude', 'listing-manager' ); ?>
            <?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
        </label>

        <input type="text"
               <?php if ( $required ) : ?>required="required"<?php endif; ?>
               id="<?php echo esc_attr( $id ); ?>_longitude"
               name="<?php echo esc_attr( $id ); ?>_longitude"
               value="<?php if ( ! empty( $value ) ) : ?><?php echo esc_html( $value ); ?><?php endif; ?>"
               class="form-control">

        <?php if ( ! empty( $_SESSION['form_errors'][ $id . '_longitude' ] ) ) : ?>
            <div class="form-error">
                <?php foreach( $_SESSION['form_errors'][ $id . '_longitude' ] as $message ) : ?>
                    <p><?php echo esc_html( $message ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div><!-- /.form-group -->
</div><!-- /.listing-manager-google-map-fields -->