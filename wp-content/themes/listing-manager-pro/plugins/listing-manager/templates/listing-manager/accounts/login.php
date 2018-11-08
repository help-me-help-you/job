<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! is_user_logged_in() ) : ?>
	<form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" class="login-form">
		<div class="form-group">
			<label for="login-form-username"><?php echo esc_html__( 'Username', 'listing-manager' ); ?></label>
			<input id="login-form-username" type="text" name="login" class="form-control" required="required">
		</div><!-- /.form-group -->

		<div class="form-group">
			<label for="login-form-password"><?php echo esc_html__( 'Password', 'listing-manager' ); ?></label>
			<input id="login-form-password" type="password" name="password" class="form-control" required="required">
		</div><!-- /.form-group -->

		<?php do_action( 'wordpress_social_login' ); ?>

		<?php do_action( 'recaptcha_print', [] ); ?>
		
		<button type="submit" name="login_form" class="button"><?php echo esc_html__( 'Log in', 'listing-manager' ); ?></button>
	</form>
<?php else: ?>
	<div class="woocommerce">
		<div class="woocommerce-error">
			<?php echo esc_html__( 'You are already logged in.', 'listing-manager' ); ?>
		</div><!-- /.woocommerce-error -->
	</div><!-- /.woocommerce -->
<?php endif; ?>