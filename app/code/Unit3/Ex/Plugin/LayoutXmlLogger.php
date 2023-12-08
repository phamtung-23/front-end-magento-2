<?php
namespace Unit3\Ex\Plugin;

use Magento\Framework\View\Result\Page as ResultPage;
use Psr\Log\LoggerInterface;

class LayoutXmlLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LayoutXmlLogger constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ResultPage $subject
     * @return array
     */
    public function beforeRenderResult(ResultPage $subject)
    {
        // Get the layout from the result page
        $layout = $subject->getLayout();

        // Get the layout XML
        $layoutXml = $layout->getXmlString();

        $this->logger->info($layoutXml);

    }
}