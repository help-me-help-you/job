<div class="listing-manager-report">
    <a href="<?php echo get_permalink( $report ); ?>?id=<?php the_ID(); ?>" class="button">    	
        <span>
        	<?php echo apply_filters( 'listing_manager_report_title', esc_html__( 'Report', 'listing-manager' ) )?>
        </span>
    </a><!-- /.button -->
</div><!-- /.listing-manager-report -->