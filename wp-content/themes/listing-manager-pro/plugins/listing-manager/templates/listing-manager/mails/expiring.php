<?php echo esc_html__( 'Hi', 'listing-manager' ); ?>,

<?php echo sprintf( esc_html__( "your package %s is going to expire. It will expire at %s. You can extend the package by logging in.", 'listing-manager' ), $package_title, $expiration_date ); ?>