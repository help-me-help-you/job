<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $name ) ) : ?>
	<strong><?php echo esc_html__( 'Name', 'listing-manager' ); ?>: </strong> <?php echo esc_html( $name ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $email ) ) : ?>
	<strong><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?>: </strong> <?php echo esc_html( $email ); ?><br><br>
<?php endif; ?>

<?php $permalink = get_permalink( $post->ID ); ?>
<?php if ( ! empty( $permalink ) ) : ?>
	<strong><?php echo esc_html__( 'URL', 'listing-manager' ); ?>: </strong> <?php echo esc_html( $permalink ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $_POST['message'] ) ) : ?>
	<?php echo esc_html( $_POST['message'] ); ?>
<?php endif; ?>