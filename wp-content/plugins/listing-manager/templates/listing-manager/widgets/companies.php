<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['classes'] ) ) : ?>
<div class="<?php echo esc_attr( $instance['classes'] ); ?>">
  <?php endif; ?>

  <?php if ( ! empty( $instance['title'] ) ) : ?>
    <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
  <?php endif; ?>

  <?php if ( have_posts() ) : ?>
    <?php if ( ! empty( $instance['description'] ) ) : ?>
      <div class="description">
        <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
      </div><!-- /.description -->
    <?php endif; ?>

    <div class="companies-small-wrapper">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="company-small">
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="company-small-thumbnail">
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
              </a>
            </div><!-- /.company-small-thumbnail -->
          <?php endif; ?>

          <div class="company-small-content">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </div><!-- /.company-small-content -->

          <a href="<?php the_permalink(); ?>" class="company-small-link"></a>
        </div><!-- /.company-small -->
      <?php endwhile; ?>
    </div><!-- /.company-small-wrapper -->
  <?php endif; ?>

  <?php if ( ! empty( $instance['classes'] ) ) : ?>
</div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
