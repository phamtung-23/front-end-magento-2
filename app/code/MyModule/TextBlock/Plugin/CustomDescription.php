<?php

namespace MyModule\TextBlock\Plugin;

use Magento\Catalog\Block\Product\View\Description;

class CustomDescription
{
    public function beforeToHtml(Description $desBlock) {
        $desBlock->getProduct()->setDescription('Custom description for the product');
    }
}