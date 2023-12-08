<?php

namespace Unit1\Ex4\Plugin;

class Footer
{
    public function afterGetCopyright(\Magento\Theme\Block\Html\Footer $footer, $result)
    {
        return 'Customized copyright!';
    }
}
