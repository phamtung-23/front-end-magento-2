<?php

namespace Cocoro\SaleOrdersReport\Block\Adminhtml\SaleOrders\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ShowButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Show Report'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
