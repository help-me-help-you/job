<div id="opening_hours" class="panel woocommerce_options_panel">
	<table class="opening-hours">
		<thead>
			<tr>
				<th></th>
				<th><?php echo esc_html__( 'Time From', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Time To', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Custom Text', 'listing-manager' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( ListingManager\Utilities::get_days() as $key => $value ): ?>
				<tr>
					<th class="day-name"><?php echo esc_attr( $value ); ?></th>
					<td class="from">
						<?php woocommerce_wp_text_input( [
							'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_from',
							'label'			=> null,
							'type' 			=> 'text',
							'class'			=> 'widefat',
						] ); ?>
					</td>					
					<td class="to">
						<?php woocommerce_wp_text_input( [
							'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' .$key . '_to',
							'label'			=> null,
							'type' 			=> 'text',
							'class'			=> 'widefat',
						] ); ?>
					</td>					
					<td class="custom">
						<?php woocommerce_wp_text_input( [
							'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' .$key . '_custom',
							'label'			=> null,
							'type' 			=> 'text',
							'class'			=> 'widefat',
						] ); ?>
					</td>						
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div><!-- /.panel -->