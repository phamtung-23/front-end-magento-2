<?php
namespace Unit5\CustomEntity\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Unit5\CustomEntity\Api\BannerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Index extends Action
{
    protected $_bannerFactory;
    protected $_pageFactory;
    protected $_bannerRepository;
    protected $_searchCriteriaBuilder;

    public function __construct(
        Context $context,
        \Unit5\CustomEntity\Model\BannerFactory $bannerFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->_bannerFactory = $bannerFactory;
        $this->_pageFactory = $pageFactory;
        $this->_bannerRepository = $bannerRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
      $searchCriteria = $this->_searchCriteriaBuilder->create();
      $banners = $this->_bannerRepository->getList($searchCriteria);
      foreach ($banners->getItems() as $banner) {
        echo 'ID:'.$banner->getId().', Link image:'.$banner->getLinkImage().', description: '.$banner->getDescription().'</br>';
      }
    }
}