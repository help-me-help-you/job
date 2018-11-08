<?php

class ListingProductType extends WC_Product {
    public function __construct( $product ) {
        $this->product_type = 'listing';
        parent::__construct( $product );
    }
}