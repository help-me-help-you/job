<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! is_user_logged_in() ) : ?>
	<form class="reset-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<div class="form-group">
			<label for="reset-form-username" ><?php echo esc_html__( 'Username or E-mail:', 'listing-manager' ); ?></label>
			<input type="text" name="user_login" id="reset-form-username" class="form-control" size="20">
		</div><!-- /.form-group -->

		<?php do_action( 'recaptcha_print', [] ); ?>
		
		<button type="submit" class="button" name="reset_form">
			<?php echo esc_html__( 'Get New Password', 'listing-manager' ); ?>
		</button>
	</form>
<?php else: ?>
	<div class="woocommerce">
		<div class="woocommerce-error">
			<?php echo esc_html__( 'You are already logged in.', 'listing-manager' ); ?>
		</div><!-- /.woocommerce-error -->
	</div><!-- /.woocommerce -->
<?php endif; ?>