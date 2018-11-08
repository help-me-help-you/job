<?php $terms = wp_get_post_terms( get_the_ID(), 'product_cat', [
        'parent' => 0,
] ); ?>

<?php if ( $terms ) : ?>
	<?php $term = array_shift( $terms ); ?>

	<div class="listing-manager-stream-item-category">
		<?php $font_icon = get_term_meta( $term->term_id, 'font_icon', true ); ?>
		<?php if ( ! empty( $font_icon ) ) : ?>
			<?php echo wp_kses_post( $font_icon ); ?>
		<?php endif; ?>

		<span><?php echo esc_html( $term->name ); ?></span>
	</div><!-- /.listing-manager-stream-item-category -->
<?php endif; ?>

<?php $location = ListingManager\Product\ListingProduct::get_location_name(); ?>
<?php if ( $location ) : ?>
	<div class="listing-manager-stream-item-location">
		<?php echo wp_kses_post( $location ); ?>
	</div><!-- /.listing-manager-stream-item-location -->
<?php endif; ?>
