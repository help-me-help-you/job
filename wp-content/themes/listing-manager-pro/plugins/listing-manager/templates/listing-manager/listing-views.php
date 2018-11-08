<div class="listing-manager-views-wrapper">
	<h2><?php echo esc_html__( 'Last two weeks views', 'listing-manager' ); ?></h2>
	<div class="listing-manager-views">
		<?php foreach( $data as $value ) : ?>
			<div class="listing-manager-view-item">
				<div class="value">
                    <span class="value-percent" style="height: <?php echo esc_attr( $value[2] * $step ); ?>%;">
                        <span class="value-count <?php echo ( 0 == $value[2] ) ? 'empty' : ''; ?>">
                            <?php echo esc_html( $value[2] ); ?>
                        </span>
                    </span>
				</div><!-- /.value -->

				<div class="key">
					<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $value[1] ) ) ); ?>
				</div><!-- /.key -->
			</div><!-- /.listing-manager-view-item -->
		<?php endforeach; ?>
	</div><!-- /.listing-manager-views -->
</div><!-- /.listing-manager-views-wrapper -->
