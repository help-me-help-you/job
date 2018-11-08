<?php 
$args = [
	'hide_empty' => false,
];

if ( ! empty( $ids ) )  {
	$args['include'] = $ids;
}
?>

<?php $terms = get_terms( 'locations', $args ); ?>

<?php if ( is_array( $terms ) ) : ?>
	<div class="listing-manager-locations-wrapper">
		<div class="listing-manager-locations">
			<?php foreach( $terms as $term ) : ?>						
				<div class="listing-manager-location">	
					<div class="listing-manager-location-inner">		
						<?php $attachment_id = get_term_meta( $term->term_id, 'pix_term_image', true ); ?>									

						<a href="<?php echo get_term_link( $term ); ?>" style="background-image: url('<?php echo wp_get_attachment_image_url( $attachment_id, 'large' ); ?>');">						
							<h3><?php echo esc_html( $term->name ); ?></h3>
							<h4><?php echo esc_html( $term->count ); ?> <?php echo esc_html__( 'listings', 'listing-manager' ); ?></h4>

							<span class="button">
								<?php echo esc_html__( 'Show All Listings', 'listing-manager' ); ?>								
							</span>
						</a>			
					</div><!-- /.listing-manager-location-inner -->
				</div><!-- /.listing-manager-location -->
			<?php endforeach; ?>
		</div><!-- /.listing-manager-locations -->
	</div><!-- /.listing-manager-locations-wrapper -->
<?php endif; ?>