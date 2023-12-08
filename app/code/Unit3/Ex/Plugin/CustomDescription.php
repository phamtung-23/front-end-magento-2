<?php

namespace Unit3\Ex\Plugin;

use Magento\Catalog\Block\Product\View\Description;

class CustomDescription
{
    public function beforeToHtml(Description $desBlock) {
        dd($desBlock->getProduct()->getDescription());
        $desBlock->getProduct()->setDescription('Custom description for the product');
    }
}