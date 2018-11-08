<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php $permalink = get_permalink( $listing->ID ); ?>
<?php if ( ! empty( $permalink ) ) : ?>
    <strong><?php echo esc_html__( 'URL', 'listing-manager' ); ?>: </strong> <?php echo esc_attr( $permalink ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $name ) ) : ?>
    <strong><?php echo esc_html__( 'Name', 'listing-manager' ); ?>: </strong> <?php echo esc_attr( $name ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $email ) ) : ?>
    <strong><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?>: </strong> <?php echo esc_attr( $email ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $reason ) ) : ?>
    <strong><?php echo esc_html__( 'Report reason', 'listing-manager' ); ?>: </strong> <?php echo esc_attr( $reason ); ?><br><br>
<?php endif; ?>

<?php if ( ! empty( $message ) ) : ?>
    <?php echo esc_html( $message ); ?>
<?php endif; ?>