<?php

namespace Unit1\Ex4\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class LogRequestUrl implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogRequestUrl constructor.
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
        // Get the request object from the observer
        $request = $observer->getData('controller_action')->getRequest();

        // Get the URL from the request object
        $url = $request->getPathInfo();

        // Log the URL into a file
        $this->logger->info('Request URL: ' . $url);
    }
}
