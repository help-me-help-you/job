<?php if ( empty( $listing ) ): ?>
	<div class="woocommerce">
		<div class="woocommerce-error">
			<?php echo esc_html__( 'Post ID is missing.', 'listing-manager' ); ?>
		</div><!-- /.woocommerce-error -->
	</div><!-- /.woocommerce -->
<?php elseif ( ListingManager\Logic\ClaimLogic::user_already_claimed( $listing->ID, get_current_user_id() ) ): ?>
	<div class="woocommerce">
		<div class="woocommerce-error">
			<?php echo esc_html__( 'You have already claimed this listing. Please, wait for admin review.', 'listing-manager' ); ?>
		</div><!-- /.woocommerce-error -->
	</div><!-- /.woocommerce -->
<?php else: ?>
	<form method="post" action="<?php echo get_the_permalink( $listing->ID ) ?>">
		<input type="hidden" name="listing_id" value="<?php echo esc_attr( $listing->ID ); ?>">

		<div class="form-group">
			<label for="claim-form-name"><?php echo esc_html__( 'Name', 'listing-manager' ); ?> <span class="required">*</span></label>
			<input id="claim-form-name" class="form-control" name="name" type="text" required="required">
		</div><!-- /.form-group -->

		<div class="form-group">
			<label for="claim-form-email"><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?> <span class="required">*</span></label>
			<input id="claim-form-email" class="form-control" name="email" type="email" required="required">
		</div><!-- /.form-group -->

		<div class="form-group">
			<label for="claim-form-phone"><?php echo esc_html__( 'Phone', 'listing-manager' ); ?> <span class="required">*</span></label>
			<input id="claim-form-phone" class="form-control" name="phone" type="text" required="required">
		</div><!-- /.form-group -->

		<div class="form-group">
			<label for="claim-form-message"><?php echo esc_html__( 'Message', 'listing-manager' ); ?> <span class="required">*</span></label>
			<textarea id="claim-form-message" class="form-control" name="message" required="required" placeholder="" rows="4"></textarea>
		</div><!-- /.form-group -->

		<div class="button-wrapper">
			<button type="submit" class="button" name="claim_form">
				<?php echo esc_html__( sprintf( 'Claim %s', get_the_title( $listing ) ), 'listing-manager' ); ?>
			</button>
		</div><!-- /.button-wrapper -->
	</form>
<?php endif; ?>