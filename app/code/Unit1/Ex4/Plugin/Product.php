<?php

namespace Unit1\Ex4\Plugin;

class Product
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $product, $result)
    {
        $newPrice = $result + 10;
        return $newPrice;
    }
}
