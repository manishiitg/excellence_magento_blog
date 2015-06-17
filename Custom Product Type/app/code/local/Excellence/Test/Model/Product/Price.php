<?php

class Excellence_Test_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price {

    public function getFinalPrice($qty = null, $product) {
        if (is_null($qty) && !is_null($product->getCalculatedFinalPrice())) {
            return $product->getCalculatedFinalPrice();
        }

        $finalPrice = parent::getFinalPrice($qty, $product);

        $finalPrice = $finalPrice - $finalPrice/10;

        return $finalPrice;
    }

}
