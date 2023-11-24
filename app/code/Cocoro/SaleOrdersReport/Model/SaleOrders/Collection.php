<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cocoro\SaleOrdersReport\Model\SaleOrders;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns([
                'entity_id', 'increment_id', 'status', 'grand_total',
                'order_type', 'subtotal', 'tax_amount',
                'subtotal_incl_tax', 'shipping_incl_tax',
                'discount_amount',
                'cococoins_spent' => 'mp_reward_earn',
                'cococoins_earn' => 'mp_reward_spent',
                'total_refunded', 'created_at' => 'CONVERT_TZ(main_table.created_at, "+00:00","+7:00")',
                'updated_at' => 'CONVERT_TZ(main_table.updated_at, "+00:00","+7:00")'
            ])
            ->join(
                ['statusTable' => $this->getTable('sales_order_status_label')],
                'main_table.status = statusTable.label AND statusTable.store_id = 5',
                [
                    'status_label' => 'label'
                ]
            )
            ->join(
                ['orderTable' => $this->getTable('sales_order_grid')],
                'main_table.entity_id = orderTable.entity_id',
                [
                    'payment_method'
                ]
            );
    }
}
