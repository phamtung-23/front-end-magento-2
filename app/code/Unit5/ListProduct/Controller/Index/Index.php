<?php
namespace Unit5\ListProduct\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\Search\FilterGroup;

use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class Index extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

 /**
     * @var FilterGroup
     */
    private $filterGroup;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepo,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        FilterGroup $filterGroup
    ) {
        $this->productRepo = $productRepo;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->filterGroup = $filterGroup;
        return parent::__construct($context);
    }

    public function execute()
    {
        $filter1 = $this->filterBuilder
            ->setField(ProductInterface::TYPE_ID)
            ->setConditionType('eq')
            ->setValue(Configurable::TYPE_CODE)
            ->create();

        $filter2 = $this->filterBuilder
            ->setField(ProductInterface::NAME)
            ->setConditionType('like')
            ->setValue('B%')
            ->create();

        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDescendingDirection()
            ->create();

        $this->searchCriteriaBuilder->addFilters([$filter1]);
        $this->searchCriteriaBuilder->addFilters([$filter2]);
        
        $this->searchCriteriaBuilder
            ->setSortOrders([$sortOrder])
            ->setPageSize(6)
            ->setCurrentPage(1);

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $productsItems  = $this->productRepo->getList($searchCriteria)->getItems();

        foreach ($productsItems as $productItem){
            echo "Type: ".$productItem->getTypeId().", ID: ".$productItem->getID()
                    .", Name: ".$productItem->getName().", SKU: ".$productItem->getSku()."</br>";
        }
    }
}