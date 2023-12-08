<?php

namespace MyModule\TextBlock\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
  
        $resultPage = $this->resultPageFactory->create();
        // // $contentContainer = $resultPage->getLayout()->getBlock('text_block_container');
        $textBlock = $resultPage->getLayout()
            ->createBlock(\Magento\Framework\View\Element\Text::class)
            ->setText('Hello, this is my custom text block!');

        $resultPage->getLayout()->setChild('content', $textBlock->getNameInLayout(), $textBlock);

        return $resultPage;

    }
}
