<?php if ( empty( $listing ) ): ?>
    <div class="alert alert-warning">
        <?php echo esc_html__( 'You have to specify listing!', 'listing-manager' ) ?>
    </div>
<?php else: ?>
    <h3><?php echo esc_html__( sprintf( 'Are you sure you want to delete "%s"?', get_the_title( $listing ) ), 'listing-manager' ); ?></h3>

    <?php $submission_list_page = get_theme_mod( 'listing_manager_pages_listing_list', false ); ?>
    <?php $action = empty( $submission_list_page ) ? get_home_url() : get_permalink( $submission_list_page ); ?>

    <form method="post" action="<?php echo $action ?>">
        <input type="hidden" name="listing_id" value="<?php echo $listing->ID; ?>">

        <div class="button-wrapper">
            <button type="submit" class="button" name="remove_listing_form">
                <?php echo esc_html__( 'Delete', 'listing-manager' ); ?>
            </button>
        </div><!-- /.button-wrapper -->
    </form>
<?php endif; ?>