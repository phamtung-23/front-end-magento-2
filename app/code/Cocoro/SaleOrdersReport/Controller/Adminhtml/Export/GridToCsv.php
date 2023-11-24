<?php

/**
 * @category Magento 2 Module
 * @package  Theiconnz\Frontendflow
 * @author   Don Nuwinda
 */

namespace Cocoro\SaleOrdersReport\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Ui\Model\Export\ConvertToCsv;
use Magento\Framework\App\Response\Http\FileFactory;
use Cocoro\SaleOrdersReport\Model\SaleOrders\Collection;

class GridToCsv extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var MetadataProvider
     */
    protected $metadataProvider;
    /**
     * @var WriteInterface
     */
    protected $directory;
    /**
     * @var ConvertToCsv
     */
    protected $converter;
    /**
     * @var FileFactory
     */
    protected $fileFactory;

    protected $resources;
    protected $_connection;
    protected $collection;



    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        Filter $filter,
        Filesystem $filesystem,
        ConvertToCsv $converter,
        FileFactory $fileFactory,
        \Magento\Ui\Model\Export\MetadataProvider $metadataProvider,
        \Magento\Sales\Model\ResourceModel\Order\Item $resource,
        Collection $collection
    ) {
        $this->resources = $resource;
        $this->filter = $filter;
        $this->_connection = $this->resources->getConnection();
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->metadataProvider = $metadataProvider;
        $this->converter = $converter;
        $this->fileFactory = $fileFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->collection = $collection;
    }

    /**
     * export.
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {

        $component = $this->filter->getComponent();
        $this->filter->prepareComponent($component);
        $dataProvider = $component->getContext()->getDataProvider();
        $dataProvider->setLimit(0, false);
        $date = $dataProvider->getDate();

        $fileName = 'Sales Order_From ' . $date['from'] . ' to ' . $date['to'];
        $total = 0;

        $data = $component->getContext()->getDataProvider()->getExportData();
        $name = hash('sha256', microtime());
        $file = 'export/' . $component->getName() . $name . '.csv';
        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $stream->writeCsv($this->metadataProvider->getHeaders($component));

        foreach ($data as $document) {
            $this->metadataProvider->convertDate($document, $component->getName());
            $stream->writeCsv($document);
        }

        $stream->unlock();
        $stream->close();

        return $this->fileFactory->create($fileName . '.csv', [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ], 'var');
    }
}
