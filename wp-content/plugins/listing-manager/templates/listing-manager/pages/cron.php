<div class="wrap">
	<h1><?php echo esc_html__( 'Cron', 'listing-manager' ); ?></h1>


    <table class="listing-manager-cron wp-list-table widefat striped">
        <tbody>
            <tr>
                <td>
                    <?php echo esc_html__( 'Unpublish passed events.', 'listing-manager' ); ?>
                </td>

                <td>
                    <a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=unpublish_passed_events">
		                <?php echo admin_url( 'admin-ajax.php' ); ?>?action=unpublish_passed_events
                    </a>
                </td>
            </tr>

            <tr>
                <td>
		            <?php echo esc_html__( 'Send notification e-mail about expiring packages.', 'listing-manager' ); ?>
                </td>

                <td>
                    <a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=notify_before_expiration_email">
			            <?php echo admin_url( 'admin-ajax.php' ); ?>?action=notify_before_expiration_email
                    </a>
                </td>
            </tr>

            <tr>
                <td>
		            <?php echo esc_html__( 'Unpublish all expired listings.', 'listing-manager' ); ?>
                </td>

                <td>
                    <a href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=check_for_expired">
			            <?php echo admin_url( 'admin-ajax.php' ); ?>?action=check_for_expired
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div><!-- /.wrap -->