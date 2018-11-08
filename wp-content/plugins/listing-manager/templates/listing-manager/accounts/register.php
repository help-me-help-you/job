<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( get_option( 'users_can_register' ) ) : ?>
	<?php if ( ! is_user_logged_in() ) : ?>
		<form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" class="register-form">
			<div class="form-group">
				<label for="register-form-name"><?php echo esc_html__( 'Username', 'listing-manager' ); ?></label>
				<input id="register-form-name" type="text" name="<?php echo LISTING_MANAGER_USER_PREFIX; ?>username" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<label for="register-form-email"><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?></label>
				<input id="register-form-email" type="email" name="<?php echo LISTING_MANAGER_USER_PREFIX; ?>email" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<label for="register-form-password"><?php echo esc_html__( 'Password', 'listing-manager' ); ?></label>
				<input id="register-form-password" type="password" name="<?php echo LISTING_MANAGER_USER_PREFIX; ?>password" class="form-control" required="required">
			</div><!-- /.form-group -->

			<div class="form-group">
				<label for="register-form-retype"><?php echo esc_html__( 'Retype Password', 'listing-manager' ); ?></label>
				<input id="register-form-retype" type="password" name="<?php echo LISTING_MANAGER_USER_PREFIX; ?>password_retype" class="form-control" required="required">
			</div><!-- /.form-group -->

			<?php $terms = get_theme_mod( 'listing_manager_pages_terms', false ); ?>

			<?php if ( ! empty( $terms ) ) : ?>
				<div class="form-group terms-conditions-input">
					<div class="checkbox">
						<label for="register-form-conditions">
							<input id="register-form-conditions" type="checkbox" name="<?php echo LISTING_MANAGER_USER_PREFIX; ?>terms">
							<?php echo sprintf( __( 'I agree with <a href="%s">terms & conditions</a>', 'listing-manager' ), get_permalink( $terms ) ); ?>
						</label>
					</div><!-- /.checkbox -->
				</div><!-- /.form-group -->
			<?php endif; ?>
			
			<button type="submit" class="button" name="register_form">
				<?php echo esc_html__( 'Sign Up', 'listing-manager' ); ?>				
			</button>
		</form>
	<?php else : ?>
		<div class="woocommerce">
			<div class="woocommerce-error">
				<?php echo esc_html__( 'You are already logged in.', 'listing-manager' ); ?>
			</div><!-- /.woocommerce-error -->
		</div><!-- /.woocommerce -->
	<?php endif; ?>
<?php else: ?>
	<div class="woocommerce">
		<div class="woocommerce-error">
			<?php echo esc_html__( 'Registrations are not allowed.', 'listing-manager' ); ?>
		</div><!-- /.woocommerce-error -->
	</div><!-- /.woocommerce -->
<?php endif; ?>