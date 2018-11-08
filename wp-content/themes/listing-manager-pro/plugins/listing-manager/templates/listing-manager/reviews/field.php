<p class="comment-form-rating">
	<label for="listing-manager-ratings-<?php echo esc_attr( $id ); ?>">
		<?php echo esc_html( $title ); ?>
		<?php if ( $required ) : ?>
			<span class="asterisk">*</span>
		<?php endif; ?>
	</label>

	<select name="<?php echo LISTING_MANAGER_REVIEW_PREFIX . esc_attr( $id ); ?>"
		    id="listing-manager-ratings-<?php echo esc_attr( $id ); ?>"
		    class="listing-manager-rating"
		    <?php if ( $required ) : ?>aria-required="true" required<?php endif; ?>>
		<option value=""><?php esc_html__( 'Rate&hellip;', 'listing-manager' ); ?></option>

		<?php for ( $i = 1; $i <= $stars; $i++ ) : ?>
			<option value="<?php echo esc_html( $i ); ?>">
				<?php echo esc_html( $i ); ?>
			</option>
		<?php endfor; ?>
	</select>
</p>
