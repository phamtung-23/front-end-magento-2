<?php 
// File: app/code/Vendor/Module/Observer/LogAvailableRouters.php
namespace Unit2\Ex\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\RouterListInterface;
use Psr\Log\LoggerInterface;

class LogAvailableRouters implements ObserverInterface
{
    /**
     * @var RouterListInterface
     */
    private $routerList;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogAvailableRouters constructor.
     * @param RouterListInterface $routerList
     * @param LoggerInterface $logger
     */
    public function __construct(RouterListInterface $routerList, LoggerInterface $logger)
    {
        $this->routerList = $routerList;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer)
    {
        // Get the list of available routers
        // $availableRouters = $this->routerList->getRoutes();
        $list = "";
        foreach ($this->routerList as $router) {
            $list .= get_class($router) . "\n";
        }
        // Log the list of available routers into a file
        $this->logger->info('Available Routers: ' . $list);
    }
}
