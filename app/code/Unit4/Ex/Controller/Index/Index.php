<?php

namespace Unit4\Ex\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;


class Index extends Action
{
    
    protected $resultPageFactory;
    protected $blockFactory;

    
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    
    public function execute()
    {
        $storeCollection = \Magento\Framework\App\ObjectManager::getInstance()
        ->create(\Magento\Store\Model\ResourceModel\Store\Collection::class);

        foreach ($storeCollection as $store) {
            $storeId = $store->getId();
            $storename = $store->getname();
            $rootCategoryId = $store->getRootCategoryId();
            
            // Retrieve category collection filtered by root category ID
            $categoryCollection = \Magento\Framework\App\ObjectManager::getInstance()
                ->create(\Magento\Catalog\Model\ResourceModel\Category\Collection::class);
            $categoryCollection->addAttributeToSelect('name')
                ->addAttributeToFilter('entity_id', $rootCategoryId)
                ->setPageSize(1);
        
            // Get the category name
            $categoryName = $categoryCollection->getFirstItem()->getName();
        
            // Echo store view and associated root category name
            echo "Store ID: " . $storeId ." | Store Name: " . $storename. " | Root Category Name: " . $categoryName . "<br>";
        }
    }
}