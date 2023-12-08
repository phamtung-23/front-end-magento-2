<?php
namespace CustomModule\CustomEntity\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CustomEntitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get custom entities list.
     *
     * @return \CustomModule\CustomEntity\Api\Data\CustomEntityInterface[]
     */
    public function getItems();

    /**
     * Set custom entities list.
     *
     * @param \CustomModule\CustomEntity\Api\Data\CustomEntityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
