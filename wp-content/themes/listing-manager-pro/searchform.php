<?php $query = ! empty( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : ''; // Input var okay; sanitization okay. ?>

<form method="get" class="form-search site-search" action="<?php echo esc_attr( home_url( '/' ) ); ?>">
    <div class="form-group">
        <input class="search-query form-control" type="text" name="s" id="s" value="<?php echo esc_attr( $query ); ?>" placeholder="<?php echo esc_attr__( 'Type to search site', 'listing-manager-pro' ); ?>">
    </div><!-- /.form-group-->

    <div class="form-group form-group-button">
    	<button type="submit" class="button button-primary button-block">
    		<?php echo esc_html__( 'Search', 'listing-manager-pro' ); ?>    		
    	</button>
    </div><!-- /.form-group -->
</form><!-- /.site-search -->