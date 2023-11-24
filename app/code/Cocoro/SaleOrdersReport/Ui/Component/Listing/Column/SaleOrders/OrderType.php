<?php

namespace Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders;

use Magento\Framework\Data\OptionSourceInterface;

class OrderType implements OptionSourceInterface
{
    const TYPE_SHARP = 'sharp';
    const TYPE_NON_SHARP = 'non_sharp';
    const TYPE_MIXED = 'mixed';
    const TYPE_VOUCHER = 'voucher';

    const LABELS = [
       self::TYPE_SHARP => 'Sharp',
       self::TYPE_NON_SHARP => 'Non-Sharp',
       self::TYPE_MIXED => 'Mixed',
       self::TYPE_VOUCHER => 'Voucher',
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
