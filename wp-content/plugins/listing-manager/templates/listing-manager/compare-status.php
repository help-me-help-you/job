<?php $count = ! empty( $_SESSION['compare'] ) ? count( $_SESSION['compare'] ) : 0; ?>

<?php if ( 0 !== $count ) : ?>
	<div class="listing-manager-compare-status">
		<p>
			<span class="listing-manager-compare-status-count"> <?php echo esc_html( $count ); ?></span><!-- /.listing-manager-compare-status-count -->
			<?php if ( 1 === $count ) : ?>
				<?php echo esc_html__( 'listing in compare.', 'listing-manager' ); ?>
			<?php else: ?>
				<?php echo esc_html__( 'listings in compare.', 'listing-manager' ); ?>
			<?php endif?>
		</p>

		<?php $page = get_theme_mod( 'listing_manager_pages_compare', null ); ?>
		<?php if ( ! empty( $page ) ) : ?>
			<a href="<?php echo get_permalink( $page ); ?>">
				<?php echo esc_html__( 'Show comparison', 'listing-manager' ); ?>
			</a>
		<?php endif; ?>
	</div><!-- /.listing-manager-compare-status -->
<?php endif; ?>
