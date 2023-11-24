<?php

namespace Cocoro\SaleOrdersReport\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Response\Http\FileFactory;

class GridToXml extends \Magento\Backend\App\Action
{

    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;


    /**
     * @var WriteInterface
     */
    protected $directory;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var \Magento\Framework\Convert\ConvertArray
     */
    protected $convertArray;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        Filesystem $filesystem,
        FileFactory $fileFactory,
        \Magento\Framework\Convert\ConvertArray $convertArray
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->fileFactory = $fileFactory;
        $this->convertArray = $convertArray;
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
        $data = $component->getContext()->getDataProvider()->getExportData();
        $items = $this->formatArray($data);
        $xmlContents = $this->convertArray->assocToXml($items, "saleOrders");
        $content = $xmlContents->asXML();
        $fileName = 'Sales Order_From ' . $date['from'] . ' to ' . $date['to'];
        $name = hash('sha256', microtime());
        $file = 'export/' . $component->getName() . $name . '.xml';
        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $stream->write($content);
        $stream->unlock();
        $stream->close();


        return $this->fileFactory->create($fileName . '.xml', [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ], 'var');
    }

    public function formatArray($collection)
    {
        $list = [];
        foreach ($collection as $index => $item) {
            $num = $index + 1;
            $key = 'order' . $num;
            $list[$key] = $item;
        }
        return $list;
    }
}
