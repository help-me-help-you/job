<?php
$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'shop_catalog' );
$product = wc_get_product( get_the_ID() );
$ids = $product->get_gallery_image_ids();
?>

<?php if ( ! empty( $featured_image ) || ! empty( $ids ) ) : ?>
    <div class="product-loop-gallery-wrapper">
        <div class="product-loop-gallery">
            <?php if ( ! empty( $featured_image ) ) : ?>
                <a href="<?php the_permalink(); ?>" class="product-loop-gallery-image image-featured" style="background-image: url(<?php echo esc_attr( $featured_image ); ?>);"></a>
            <?php endif; ?>

            <?php foreach( $ids as $id ) : ?>
                <?php $image = wc_get_product_attachment_props( $id ); ?>
                <a href="<?php the_permalink(); ?>" class="product-loop-gallery-image image-gallery" style="background-image: url(<?php echo esc_attr( $image['src'] ); ?>);"></a>
            <?php endforeach; ?>
        </div><!-- /.product-loop-gallery -->

	    <?php $product = wc_get_product();?>
        <?php if ( $product->get_average_rating() ) : ?>
    	    <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
        <?php endif; ?>
    </div><!-- /.product-loop-gallery-wrapper -->
<?php endif; ?>
