<?php
namespace CustomModule\CustomEntity\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomEntity extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_entity_table', 'entity_id'); // Replace 'custom_entity_table' and 'entity_id' with your table name and primary key
    }
}
