<?php
namespace Unit5\ListProduct\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Customer\Api\CustomerRepositoryInterface;

class ProductList extends Template
{
    protected $productRepository;
    protected $_searchCriteriaBuilder;
    protected $_filterBuilder;
    protected $customerRepository;

    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->customerRepository = $customerRepository;
    }

    public function getProductList()
    {
       
        // // Fetch products with filters, sorting, and limit
        // $searchCriteria = $this->_searchCriteriaBuilder
        //     ->addFilter('status', 1) // Active products only
        //     ->addFilter('category_id', 5) // Example filter: products in category with ID 5
        //     ->setPageSize(6) // Limit the number of products to 6
        //     ->setCurrentPage(1)
        //     ->create();
       $filter1 = $this->_filterBuilder
        ->setField(ProductInterface::NAME)
        ->setConditionType('like')
        ->setValue('%hoodie%')
        ->create();
        $this->_searchCriteriaBuilder->addFilters([$filter1])->setPageSize(6);
        $searchCriteria = $this->_searchCriteriaBuilder->create();

        $products = $this->productRepository->getList($searchCriteria);
        return $products->getItems();
    }

    public function getCustomerList()
    {
       $filter1 = $this->_filterBuilder
            ->setField(CustomerInterface::FIRSTNAME)
            ->setConditionType('like')
            ->setValue('P%')
            ->create();

        $filter2 = $this->_filterBuilder
            ->setField(CustomerInterface::EMAIL)
            ->setConditionType('like')
            ->setValue('r%')
            ->create();


        $this->_searchCriteriaBuilder->addFilters([$filter1, $filter2]);
    

        $searchCriteria = $this->_searchCriteriaBuilder->create();

        $customerItems  = $this->customerRepository->getList($searchCriteria);
        return $customerItems->getItems();
    }
}