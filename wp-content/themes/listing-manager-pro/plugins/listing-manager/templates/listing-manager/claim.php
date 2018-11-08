<div class="listing-manager-claim">
	<?php if ( ! $is_verified ): ?>
		<?php if ( ListingManager\Logic\ClaimLogic::user_already_claimed( $listing_id, get_current_user_id() ) ) : ?>
			<a class="button listing-manager-button-claim"
			   href="<?php echo get_permalink( $claim_page ); ?>?id=<?php echo esc_attr( $listing_id ); ?>" data-listing-id="<?php echo esc_attr( $listing_id ); ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<?php echo esc_attr__( 'I claimed it', 'listing-manager' ); ?>
			</a><!-- /.button -->
		<?php else : ?>
			<a class="button listing-manager-button-claim marked"
			   href="<?php echo get_permalink( $claim_page ); ?>?id=<?php echo esc_attr( $listing_id ); ?>" data-listing-id="<?php echo esc_attr( $listing_id ); ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<?php echo esc_attr__( 'Claim', 'listing-manager' ); ?>
			</a><!-- /.button -->
		<?php endif ; ?>
	<?php endif ; ?>
</div><!-- /.listing-manager-claim -->
