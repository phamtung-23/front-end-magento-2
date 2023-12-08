<?php 
// File: app/code/Vendor/Module/Controller/Index/Index.php
namespace Unit3\RenderTextInController\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // Create a new page result
        $resultPage = $this->resultPageFactory->create();


        $layout = $this->_view->getLayout();
        $block = $layout->createBlock('\Unit3\RenderTextInController\Block\HelloWorld');
        $layout->setChild('content',$block->getNameInLayout(), $block); 

        return $resultPage;
    }
}