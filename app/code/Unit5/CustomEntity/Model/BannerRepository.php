<?php
namespace Unit5\CustomEntity\Model;

use Unit5\CustomEntity\Api\BannerRepositoryInterface;
use Unit5\CustomEntity\Api\Data\BannerInterface;
use Unit5\CustomEntity\Api\Data\BannerInterfaceFactory;
use Unit5\CustomEntity\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var BannerInterfaceFactory
     */
    protected $bannerFactory;

    /**
     * @var CollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * BannerRepository constructor.
     * @param BannerInterfaceFactory $bannerFactory
     * @param CollectionFactory $bannerCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        BannerInterfaceFactory $bannerFactory,
        CollectionFactory $bannerCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BannerInterface $banner)
    {
        // Implement the save logic here
    }

    /**
     * {@inheritdoc}
     */
    public function getById($bannerId)
    {
        // Implement the getById logic here
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BannerInterface $banner)
    {
        // Implement the delete logic here
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($bannerId)
    {
        // Implement the deleteById logic here
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Unit5\CustomEntity\Model\ResourceModel\Banner\Collection $collection */
        $collection = $this->bannerCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}