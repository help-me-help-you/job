<div class="product-rating">
    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
        <?php if ( $i <= $rating ) : ?>
            <i class="silk silk-star-full"></i>
        <?php else: ?>
            <i class="silk silk-star"></i>
        <?php endif; ?>
    <?php endfor; ?>
</div><!-- /.product-rating -->
