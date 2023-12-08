<?php
namespace CustomModule\CustomEntity\Api;

use CustomModule\CustomEntity\Model\CustomEntity;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomEntityRepositoryInterface
{
    /**
     * Retrieve a list of custom entities based on given search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \CustomModule\CustomEntity\Api\Data\CustomEntitySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
