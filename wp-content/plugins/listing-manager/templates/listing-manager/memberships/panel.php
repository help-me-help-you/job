<?php global $post; ?>

<div id="listing-manager" class="panel woocommerce_options_panel">
	<div class="table-wrap">
		<div class="options_group">
			<?php wp_nonce_field( 'listing-manager-membership-plan', 'listing-manager-nonce' ); ?>
			<?php $max = get_post_meta( $post->ID, LISTING_MANAGER_MEMBERSHIP_PREFIX . 'max', true ); ?>

			<p class="form-field post_name_field ">
				<label for="listing-manager-max"><?php echo esc_html__( 'Max. number of listings', 'listing-manager' ); ?>:</label>
				<input type="text" name="<?php echo LISTING_MANAGER_MEMBERSHIP_PREFIX; ?>max" id="listing-manager-max" value="<?php echo esc_attr( $max ); ?>">
			</p>
		</div>
	</div>
</div>