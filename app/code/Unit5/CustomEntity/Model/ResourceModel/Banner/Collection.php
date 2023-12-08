<?php

namespace Unit5\CustomEntity\Model\ResourceModel\Banner;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Unit5\CustomEntity\Model\Banner', 'Unit5\CustomEntity\Model\ResourceModel\Banner');
    }
}