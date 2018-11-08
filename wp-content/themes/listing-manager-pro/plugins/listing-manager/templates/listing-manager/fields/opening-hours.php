<table class="table listing-manager-submission-opening-hours">
    <thead>
        <tr>
            <th></th>
            <th><?php echo esc_html__( 'Time From', 'listing-manager' ); ?></th>
            <th><?php echo esc_html__( 'Time To', 'listing-manager' ); ?></th>
            <th><?php echo esc_html__( 'Custom Text', 'listing-manager' ); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach( ListingManager\Utilities::get_days() as $key => $value ) : ?>
            <?php $prefix = $id . '_' . $key; ?>
            <tr>
                <td class="day-name"><?php echo esc_html( $value ); ?></td>
                <?php $from = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $prefix . '_from', true ) : ''; ?>
                <td>
                    <div class="form-group">
                        <input type="text" class="from form-control" name="<?php echo esc_attr( $prefix ); ?>_from" value="<?php echo esc_attr( $from ); ?>">
                    </div><!-- /.form-group -->
                </td>

                <?php $to = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $prefix . '_to', true ) : ''; ?>
                <td>
                    <div class="form-group">
                        <input type="text" class="to form-control" name="<?php echo esc_attr( $prefix ); ?>_to" value="<?php echo esc_attr( $to ); ?>">
                    </div><!-- /.form-group -->
                </td>

                <?php $custom = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], $prefix . '_custom', true ) : ''; ?>
                <td>
                    <div class="form-group">
                        <input type="text" class="custom-text form-control" name="<?php echo esc_attr( $prefix ); ?>_custom" value="<?php echo esc_attr( $custom ); ?>">
                    </div><!-- /.form-group -->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>