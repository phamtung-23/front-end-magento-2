<?php

namespace Cocoro\SaleOrdersReport\Ui\DataProvider\Form;

use Magento\Framework\App\Request\Http as Request;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistor;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $request;
    protected $storeManager;
    protected $dataPersistor;
    protected $loadedData;
    

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Request $request,
        OrderCollection $collection,
        StoreManagerInterface $storeManager,
        DataPersistor $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        
        $data = [];

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return [];
    }

    /**
     * Alias for self::setOrder()
     *
     * @param string $field
     * @param string $direction
     * @return void
     */
    public function addOrder($field, $direction)
    {
        return [];
    }

    public function setLimit($offset, $size)
    {
        return [];
    }
}
