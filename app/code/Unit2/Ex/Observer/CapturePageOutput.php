<?php 
// File: app/code/Vendor/Module/Observer/CapturePageOutput.php
namespace Unit2\Ex\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class CapturePageOutput implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CapturePageOutput constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\App\Response\Http $response */
        $response = $observer->getData('response');

        // Get the HTML content of the response
        $htmlContent = $response->getBody();

        // Log the HTML content into a file
        // $this->logger->info('Captured Page Output: ' . $htmlContent);
    }
}
