<?php if ( empty( $_COOKIE['listing-manager-dismiss-purchase'] ) ) : ?>
	<div class="notice-warning settings-error notice listing-manager-settings-error">
	    <p>
	        <?php echo wp_kses( 'It looks like that you are missing <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code">purchase code</a>. You can configure it under <a href="' . admin_url( 'customize.php?autofocus[control]=listing_manager_purchase_code' ) . '">Customizer - Listing Manager General - Purchase Code</a>. If you don\'t have purchase code you can <a href="https://codecanyon.net/item/listing-manager-directory-listings-for-woocommerce/16250019?ref=CodeVisionThemes" target="_blank">purchase Listing Manager</a> at CodeCanyon.', wp_kses_allowed_html('post') ); ?>
	    </p>

	    <button type="button" class="notice-dismiss listing-manager-dismiss-purchase">
	        <span class="screen-reader-text"><?php echo esc_html__( 'Dismiss this notice.', 'listing-manager' ); ?></span>
	    </button>
	</div>
<?php endif; ?>