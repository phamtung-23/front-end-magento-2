<?php
namespace Unit5\CustomEntity\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Unit5\CustomEntity\Api\Data\BannerInterface;

interface BannerRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param BannerInterface $banner
     * @return BannerInterface
     */
    public function save(BannerInterface $banner);

    /**
     * Retrieve banner by ID.
     *
     * @param int $bannerId
     * @return BannerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If banner with the specified ID does not exist.
     */
    public function getById($bannerId);

    /**
     * Delete banner.
     *
     * @param BannerInterface $banner
     * @return bool
     */
    public function delete(BannerInterface $banner);

    /**
     * Delete banner by ID.
     *
     * @param int $bannerId
     * @return bool
     */
    public function deleteById($bannerId);

    /**
     * Retrieve custom entities matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}