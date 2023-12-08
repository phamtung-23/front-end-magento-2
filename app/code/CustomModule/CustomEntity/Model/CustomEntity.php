<?php
namespace CustomModule\CustomEntity\Model;

use Magento\Framework\Model\AbstractModel;

class CustomEntity extends AbstractModel
{
    protected $_idFieldName = 'entity_id'; // Replace with your primary key field name

    protected function _construct()
    {
        $this->_init('CustomModule\CustomEntity\Model\ResourceModel\CustomEntity');
    }
}
