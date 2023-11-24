<?php

namespace Cocoro\SaleOrdersReport\Block\Adminhtml\SaleOrders\Button;

use Magento\Framework\App\ObjectManager;

/**
 * Class GenericButton
 */
class GenericButton
{
    protected $context;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Return Banner ID
     */
    public function getSchedulerId()
    {
        return $this->context->getRequest()->getParam('id');
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
