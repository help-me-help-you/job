<?php

class PackageProductType extends WC_Product {
    public function __construct( $product ) {
        $this->product_type = 'package';
        parent::__construct( $product );
    }
}