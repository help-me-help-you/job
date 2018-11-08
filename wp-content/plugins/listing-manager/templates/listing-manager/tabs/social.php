<h2><?php echo esc_html__( 'Social Networks', 'listing-manager' ); ?></h2>

<?php $networks = ListingManager\Tab\SocialTab::get_networks(); ?>

<?php if ( is_array( $networks ) ) : ?>
	<div class="listing-manager-social-networks">
		<?php foreach ( $networks as $key => $value ) : ?>
			<?php $meta = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'social_' . $key, true ); ?>
			<?php if ( ! empty( $meta ) ) : ?>
				<div class="listing-manager-social-network">
					<a 	class="<?php echo esc_attr( $key ); ?>" 
						target="_blank"
						href="<?php echo esc_attr( $meta ); ?>">
						<span><?php echo esc_html( $value ); ?></span></a>
				</div><!-- /.listing-manager-social-network -->
			<?php endif; ?>
		<?php endforeach; ?>
	</div><!-- /.listing-manager-social-networks -->
<?php endif; ?>