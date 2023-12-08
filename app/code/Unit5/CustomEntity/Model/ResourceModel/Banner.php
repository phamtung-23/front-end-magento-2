<?php

namespace Unit5\CustomEntity\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    public function _construct()
    {
        $this->_init('banner_entity', 'entity_id');
    }
}