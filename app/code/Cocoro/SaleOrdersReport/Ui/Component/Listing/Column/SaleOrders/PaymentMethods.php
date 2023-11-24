<?php

namespace Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders;

use Magento\Framework\Data\OptionSourceInterface;

class PaymentMethods implements OptionSourceInterface
{
    const TYPE_PAYOOO = 'payoo';
    const TYPE_COD = 'cashondelivery';
    const TYPE_NOTREQUIRED = "free";

    const LABELS = [
       self::TYPE_PAYOOO => 'Payoo',
       self::TYPE_COD => 'Cash On Delivery',
       self::TYPE_NOTREQUIRED => 'Not Required'
    ];

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach (self::LABELS as $type => $label) {
            $options[] = [
                'label' => $label,
                'value' => $type,
            ];
        }

        return $options;
    }
}
