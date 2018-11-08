<div class="infobox">
    <div class="infobox-close"><i class="fa fa-close"></i></div>

    <h3 class="infobox-title">
        <a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
    </h3>

	<?php $location = ListingManager\Product\ListingProduct::get_location_name(); ?>
    <?php if ( ! empty( $location ) ) : ?>
        <h4 class="infobox-address">
            <?php echo $location; ?>
        </h4>
    <?php endif; ?>

    <div class="infobox-content">
	    <?php $image_url = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
        <div class="infobox-image" <?php if ( ! empty( $image_url ) ) : ?>style="background-image: url('<?php echo esc_attr( $image_url ); ?>');"<?php endif; ?>></div>

        <div class="infobox-body">
            <div class="infobox-body-inner">

                <?php $price = get_post_meta( get_the_ID(), '_regular_price', true );?>
                <?php if ( ! empty( $price ) ) : ?>
	                <?php $product = wc_get_product( get_the_ID() ); ?>
                    <div class="infobox-price"><?php echo wc_price( wc_get_price_to_display( $product ) ); ?></div>
                <?php endif; ?>

                <?php $categories = wp_get_post_terms( get_the_ID(), 'product_cat' ); ?>
                <?php if ( ! empty( $categories ) ) : ?>
                    <?php foreach( $categories as $category ) : ?>
                        <div class="infobox-category"><?php echo esc_html( $category->name ); ?></div>
                    <?php endforeach?>
                <?php endif; ?>

                <p><?php the_excerpt(); ?></p>
            </div>
        </div>
    </div>
</div>