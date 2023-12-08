<?php
namespace CustomModule\CustomEntity\Model\ResourceModel\CustomEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CustomModule\CustomEntity\Model\CustomEntity;
use CustomModule\CustomEntity\Model\ResourceModel\CustomEntity as CustomEntityResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id'; // Replace with your primary key field name

    protected function _construct()
    {
        $this->_init(CustomEntity::class, CustomEntityResourceModel::class);
    }
}
