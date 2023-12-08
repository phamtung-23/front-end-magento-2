<?php

namespace Unit5\CustomEntity\Model;

use \Magento\Framework\Model\AbstractModel;
use Unit5\CustomEntity\Api\Data\BannerInterface;

class Banner extends AbstractModel implements BannerInterface
{

    public function _construct()
    {
        $this->_init('Unit5\CustomEntity\Model\ResourceModel\Banner');
    }

    public function getId()
    {
        return $this->getData('entity_id');
    }

    public function setId($id)
    {
        return $this->setData('entity_id', $id);
    }

    public function getLinkImage(){
        return $this->getData('linkimg').'tesst!!!!!';
    }

    public function setLinkimg($linkimg){
        return $this->setData('linkimg', $linkimg);
    }

    public function getDescription(){
        return $this->getData('des');
    }

    public function setDescription($des){
        return $this->setData('des', $des);
    }

}