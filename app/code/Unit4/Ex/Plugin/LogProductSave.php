<?php
namespace Unit4\Ex\Plugin;

use Psr\Log\LoggerInterface;
use \Magento\Catalog\Model\ResourceModel\Product;
use \Magento\Framework\DataObject ;

class LogProductSave
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LogPageOutput constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeSave( Product $subject, DataObject $object) 
    {
        // dd($object->getOrigData());
        if ($object->getOrigData() === null){
            $this->logger->debug(json_encode($object->getData()));
        }else{
            $result = array_udiff_assoc($object->getData(), $object->getOrigData(),
                function ($x,$y){
                     return ($x === $y)? 0 : 1;
                 }
         
             );
            $this->logger->debug(json_encode($result));
        }
    }
}