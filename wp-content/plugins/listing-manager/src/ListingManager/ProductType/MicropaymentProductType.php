<?php

class MicropaymentProductType extends WC_Product {
    public function __construct( $product ) {
        $this->product_type = 'micropayment';
        parent::__construct( $product );
    }
}