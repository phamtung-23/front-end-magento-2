<?php

declare(strict_types=1);

namespace Cocoro\SaleOrdersReport\Block\Adminhtml\Report;

use Magento\Framework\App\Request\DataPersistor;
use Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders\OrderType;
use Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders\PaymentMethods;
use Magento\Framework\Pricing\Helper\Data as Helper;

class Totals extends \Magento\Backend\Block\Dashboard\Bar
{


    protected $dataPersistor;
    protected $collection;
    protected $orderInterface;
    protected $date;
    protected $orderType;
    protected $methods;
    protected $helper;

    /**
     * @var string
     */
    protected $_template = 'Cocoro_SaleOrdersReport::report/totalbar.phtml';

    /**
     * Totals constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Cocoro\SaleOrdersReport\Model\SaleOrders\Collection $collection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Cocoro\SaleOrdersReport\Model\SaleOrders\Collection $collection,
        DataPersistor $dataPersistor,
        \Magento\Sales\Api\OrderRepositoryInterface $orderInterface,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        OrderType $orderType,
        PaymentMethods $methods,
        Helper $helper,
        array $data = []
    ) {
        $this->collection = $collection;
        $this->dataPersistor = $dataPersistor;
        $this->orderInterface = $orderInterface;
        $this->date = $date;
        $this->orderType = $orderType;
        $this->methods = $methods;
        $this->helper = $helper;
        parent::__construct($context, $collectionFactory, $data);
    }

    /**
     * @inheritDoc
     * @return $this|void
     */
    protected function _prepareLayout()
    {

        $totalOrders = 0;
        $saleTotal = 0;
        $totalCc = 0;
        $totalCod = 0;
        $totalDiscount = 0;
        $totalCoinSpent = 0;
        $totalCoinEarn = 0;
        $totalRefunded = 0;

        $formData = $this->dataPersistor->get("saleorders_form");


        if (isset($formData['form_key'])) {

            $collection = $this->collection;
            $subTime = new \DateInterval('P0Y0M0DT7H0M0S');
            $addTimeTo = new \DateInterval('P0Y0M0DT16H59M59S');
            $date_used = $formData['saleorders_date_used'];
            if (array_key_exists('saleorders_order_type', $formData)) {
                $types =  $formData['saleorders_order_type'];
            }
            if (array_key_exists('saleorders_order_status', $formData)) {
                $status = $formData['saleorders_order_status'];
            }
            if (array_key_exists('saleorders_order_payment', $formData)) {
                $payment = $formData['saleorders_order_payment'];
            }


            if (array_key_exists('saleorders_period_from', $formData)) {
                $dateFrom = date_create($formData['saleorders_period_from'])->sub($subTime)->format('Y-m-d H:i:s');
            }
            if (array_key_exists('saleorders_period_to', $formData)) {
                $dateTo = date_create($formData['saleorders_period_to'])->add($addTimeTo)->format('Y-m-d H:i:s');
            }

            $collection->addFieldToFilter('main_table.' . $date_used, ['gteq' => $dateFrom])
                ->addFieldToFilter('main_table.' . $date_used, ['lteq' => $dateTo]);


            if (!empty($types)) {
                $list = [];
                foreach ($types as $type) {
                    array_push($list, $this->orderType::LABELS[$type]);
                }
                $collection->addFieldToFilter('main_table.order_type', ['in' => $list]);
            }
            if (!empty($status)) {
                $collection->addFieldToFilter('main_table.status', ['in' => $status]);
            }
            if (!empty($payment)) {
                $collection->addFieldToFilter('orderTable.payment_method', ['in' => $payment]);
            }

            $collection = $collection->getData();

            $collection = $this->getSaleOrders($collection);

            if (count($collection) > 0) {
                $totalOrders = count($collection);
                foreach ($collection as $item) {
                    $saleTotal += $item['grand_total'];
                    if ($item['payment_method'] == $this->methods::LABELS[$this->methods::TYPE_COD]) {
                        $totalCod += $item['grand_total'];
                    }
                    if ($item['payment_method'] == $this->methods::LABELS[$this->methods::TYPE_PAYOOO]) {
                        $totalCc += $item['grand_total'];
                    }
                    $totalDiscount += $item["discount_amount"];
                    $totalCoinSpent += $item["cococoins_spent"];
                    $totalCoinEarn += $item["cococoins_earn"];
                    $totalRefunded += $item["total_refunded"];
                }
            }
        }
        $saleTotal = $this->helper->currency($saleTotal, true, false);
        $totalCc = $this->helper->currency($totalCc, true, false);
        $totalCod = $this->helper->currency($totalCod, true, false);
        $totalDiscount = $this->helper->currency($totalDiscount, true, false);
        $totalRefunded = $this->helper->currency($totalRefunded, true, false);

        $this->_totals[] = ['label' => 'Total Orders', 'value' => $totalOrders, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Sales Total', 'value' => $saleTotal, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total - Cash On Delivery', 'value' => $totalCod, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total - Credit Card', 'value' => $totalCc, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total Discount', 'value' => $totalDiscount, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total Coco Coins Spent', 'value' => $totalCoinSpent, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total Coco Coins Earn', 'value' => $totalCoinEarn, 'decimals' => ""];
        $this->_totals[] = ['label' => 'Total Refunded', 'value' => $totalRefunded, 'decimals' => ""];

        return $this;
    }

    public function getSaleOrders($collection)
    {
        $temp = [];
        $date_used = $this->dataPersistor->get("saleorders_form")['saleorders_date_used'];
        foreach ($collection as $order) {
            $order['payment_method'] = $this->methods::LABELS[$order['payment_method']];
            array_push($temp, $order);
        }
        return $temp;
    }
}
