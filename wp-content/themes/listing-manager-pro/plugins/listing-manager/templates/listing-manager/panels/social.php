<div id="social" class="panel woocommerce_options_panel">
	<?php $networks = ListingManager\Tab\SocialTab::get_networks(); ?>

	<?php if ( is_array( $networks ) ) : ?>

		<?php foreach( $networks as $key => $value ) : ?>
			<?php woocommerce_wp_text_input( [
				'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'social_' . $key,
				'label'			=> $value,
				'type' 			=> 'text',
				'wrapper_class'	=> 'options_group',
			] ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div><!-- /.panel -->