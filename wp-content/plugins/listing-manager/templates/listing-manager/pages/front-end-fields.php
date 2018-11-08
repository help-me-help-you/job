<div class="wrap">
    <h1><?php echo esc_html__( 'Front End Fields', 'listing-manager' ); ?></h1>

    <?php $fieldsets = ListingManager\Logic\SubmissionLogic::get_fields(); ?>

    <?php foreach ( $fieldsets as $fieldset ) : ?>
        <table class="listing-manager-fields wp-list-table widefat striped">
            <tbody>
                <tr>
                    <td class="title">
                        <?php echo esc_html__( 'Fieldset', 'listing-manager' ); ?>
                    </td>

                    <td>
                        <?php echo esc_html( $fieldset['legend'] ); ?> <small>(<?php echo esc_html__( 'ID', 'listing-manager' ); ?>: <?php echo esc_html('legend' ); ?>)</small>
                    </td>
                </tr>

                <tr>
                    <td class="title">
                        <?php echo esc_html__( 'Forms', 'listing-manager' ); ?>
                    </td>

                    <td>
                        <?php $index = 0; ?>
                        <?php if ( is_array( $fieldset['forms'] ) ) : ?>
                            <?php foreach ( $fieldset['forms'] as $form ) : ?>
                                <?php echo esc_html( $form ); ?><?php echo ($index + 1 !== count( $fieldset['forms'] ) ) ? ', ' : null; ?>
                                <?php $index++; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php echo esc_html__( 'Nothing found', 'listing-manager' ); ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td class="title">
                        <?php echo esc_html__( 'Fields', 'listing-manager' ); ?>
                    </td>

                    <td>
                        <ul>
                            <?php foreach( $fieldset['fields'] as $field ) : ?>
                                <li>
                                    <?php echo esc_html( $field['label'] ); ?> <small>(<?php echo esc_html__( 'ID', 'listing-manager' ); ?>: <?php echo esc_html( $field['id'] ); ?>, <?php echo esc_html__( 'Type', 'listing-manager' ); ?>: <?php echo esc_html( $field['type'] ); ?>)</small></dd>
                                    <pre><code>&lt;?php echo get_post_meta( get_the_ID(), '<?php echo esc_html( $field['id'] ); ?>', true ); ?&gt;</code></pre>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</div><!-- /.wrap -->