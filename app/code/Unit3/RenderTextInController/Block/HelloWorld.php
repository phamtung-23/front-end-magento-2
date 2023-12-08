<?php 
// File: app/code/Vendor/Module/Block/HelloWorld.php
namespace Unit3\RenderTextInController\Block;

use Magento\Framework\View\Element\AbstractBlock;

class HelloWorld extends AbstractBlock
{
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        return '<h1>Hello World!</h1>';
    }
}
