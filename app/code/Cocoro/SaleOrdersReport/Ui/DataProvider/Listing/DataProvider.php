<?php

namespace Cocoro\SaleOrdersReport\Ui\DataProvider\Listing;

use Cocoro\SaleOrdersReport\Model\SaleOrders\Collection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistor;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Magento\Sales\Block\Adminhtml\Order\View\Info;
use Magento\Framework\Pricing\Helper\Data as Helper;
use Magento\Framework\Escaper;
use Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders\OrderType;
use Cocoro\SaleOrdersReport\Ui\Component\Listing\Column\SaleOrders\PaymentMethods;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{

    protected $request;
    protected $storeManager;
    protected $productCollectionFactory;
    protected $filterBuilder;
    protected $dataPersistor;
    protected $collection;
    protected $date;
    protected $helper;
    protected $orderInterface;
    protected $orderInfo;
    protected $escaper;
    protected $orderType;
    protected $methods;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Reporting $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     * @param array $additionalFilterPool
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        StoreManagerInterface $storeManager,
        DataPersistor $dataPersistor,
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Sales\Model\OrderRepository $orderInterface,
        Info $orderInfo,
        Helper $helper,
        Escaper $escaper,
        OrderType $orderType,
        PaymentMethods $methods,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->collection = $collection;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->filterBuilder = $filterBuilder;
        $this->dataPersistor = $dataPersistor;
        $this->date = $date;
        $this->orderInterface = $orderInterface;
        $this->helper = $helper;
        $this->orderInfo = $orderInfo;
        $this->escaper = $escaper;
        $this->orderType = $orderType;
        $this->methods = $methods;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $data = [
            "totalRecords" => 0,
            "items" => ''
        ];
        $params = $this->request->getParams();
        $formData = $this->dataPersistor->get("saleorders_form");
        $utc_timezone = new \DateTimeZone("UTC");

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

            $collection = $this->reIndex($collection);
            $collection = $this->formatCurrency($collection);

            $pageData = $collection;

            $data = [
                "totalRecords" => count($collection),
                "items" => $pageData,
                "totals" => $this->getTotals($collection)
            ];
        }

        return $data;
    }

    public function getSaleOrders($collection)
    {
        $temp = [];
        $date_used = $this->dataPersistor->get("saleorders_form")['saleorders_date_used'];
        foreach ($collection as $order) {
            $date = date_create($order[$date_used])->format('dmy');
            $order['payment_method'] = $this->methods::LABELS[$order['payment_method']];
            if (!array_key_exists($date, $temp)) {
                $temp[$date] = ['date' => date_create($order[$date_used])->format('M d,Y'), 'orders' => [$order]];
            } else {
                array_push($temp[$date]['orders'], $order);
            }
        }
        return $temp;
    }

    public function reIndex($collection)
    {
        $list = [];
        $i = 1;
        foreach ($collection as $row) {
            $arr = [];
            if ($row) {
                $arr['id'] = $i;
                $arr['reported_date'] = $row['date'];
                $arr['orders'] = count($row['orders']);
                $arr['subtotal'] = 0;
                $arr['tax_amount'] = 0;
                $arr['subtotal_incl_tax'] = 0;
                $arr['shipping_incl_tax'] = 0;
                $arr['discount_amount'] = 0;
                $arr['cococoins_spent'] = 0;
                $arr['cococoins_earn'] = 0;
                $arr['grand_total'] = 0;
                $arr['total_refunded'] = 0;
                foreach ($row['orders'] as $order) {
                    $arr['subtotal'] += $order['subtotal'];
                    $arr['tax_amount'] += $order['tax_amount'];
                    $arr['subtotal_incl_tax'] += $order['subtotal_incl_tax'];
                    $arr['shipping_incl_tax'] += $order['shipping_incl_tax'];
                    $arr['discount_amount'] += $order['discount_amount'];
                    $arr['cococoins_spent'] += $order['cococoins_spent'];
                    $arr['cococoins_earn'] += $order['cococoins_earn'];
                    $arr['grand_total'] += $order['grand_total'];
                    $arr['total_refunded'] += $order['total_refunded'];
                }
                array_push($list, $arr);
                foreach ($row['orders'] as $order) {
                    $order['orders'] = $order['increment_id'];
                    $order['purchase_date'] = $order['created_at'];
                    $order['order_status'] = $order['status_label'];
                    array_push($list, $order);
                }
            }
            $i++;
        }
        return $list;
    }

    public function getTotals($collection)
    {
        $list = [];
        $keys = [
            'id', 'reported_date', 'orders',
            'purchase_date', 'order_stastus', 'order_type', 'payment_method',
            'subtotal', 'tax_amount', 'subtotal_incl_tax',
            'shipping_incl_tax', 'discount_amount', 'cococoins_spent',
            'cococoins_earn', 'grand_total', 'total_refunded'
        ];
        foreach ($keys as $key) {
            $total = 0;
            if (!in_array($key, ['id', 'reported_date', 'purchase_date', 'order_stastus', 'order_type', 'payment_method'])) {
                foreach ($collection as $item) {
                    if (array_key_exists("id", $item)) {
                        $total += $item[$key];
                    }
                }
            }
            if (!in_array($key, ["orders", "cococoins_spent", "cococoins_earn"])) {
                $total = number_format($total);
            }
            if (in_array($key, ['id', 'reported_date', 'purchase_date', 'order_stastus', 'order_type', 'payment_method'])) {
                $total = "";
            }
            $list[$key] = $total;
        }
        return $list;
    }



    public function toList($collection)
    {
        $list = [];
        $keys = [
            'id', 'orders', 'purchase_date', 'order_status',
            'order_type', 'subtotal_with_currency', 'tax_with_currency',
            'subtotal_tax_with_currency', 'shipping_with_currency',
            'discount_with_currency', 'cococoins_spent', 'cococoins_earn',
            'sales_total_with_currency', 'created_at', 'updated_at',
            'refunded_with_currency'
        ];
        foreach ($collection as $item) {
            $temp = array_intersect_key($item, array_flip($keys));
            foreach ($keys as $key) {
                $order[$key] = $temp[$key];
            }
            array_push($list, $order);
        }
        return $list;
    }

    public function getDate()
    {

        $formData = $this->dataPersistor->get("saleorders_form");

        if (isset($formData['form_key'])) {
            if (array_key_exists('saleorders_period_from', $formData)) {
                $dateFrom = date_create($formData['saleorders_period_from'])->format('dmY');
            }
            if (array_key_exists('saleorders_period_to', $formData)) {
                $dateTo = date_create($formData['saleorders_period_to'])->format('dmY');
            }
        }
        return ['from' => $dateFrom, 'to' => $dateTo];
    }

    public function getExportData()
    {
        $collection = $this->getData()['items'];
        $totals = $this->getTotals($collection);

        $list = [];

        $keys = [
            'id', 'reported_date', 'orders', 'purchase_date', 'order_status',
            'order_type', 'payment_method', 'subtotal_with_currency', 'tax_with_currency',
            'subtotal_tax_with_currency', 'shipping_with_currency',
            'discount_with_currency', 'cococoins_spent', 'cococoins_earn',
            'sales_total_with_currency', 'refunded_with_currency'
        ];

        foreach ($collection as $item) {
            $temp = array_intersect_key($item, array_flip($keys));
            foreach ($keys as $key) {
                if (isset($temp[$key])) {
                    $order[$key] = $this->escaper->escapeHtml($temp[$key]);
                } else {
                    $order[$key] = $this->escaper->escapeHtml("");
                }
            }
            array_push($list, $order);
        }
        if (!empty($totals)) {
            $totals['id'] = $this->escaper->escapeHtml("Total");
            array_push($list, $totals);
        }
        return $list;
    }

    public function formatCurrency($collection)
    {
        $list = [];
        foreach ($collection as $item) {
            $item['subtotal_with_currency'] = number_format($item['subtotal']);
            $item['tax_with_currency'] = number_format($item['tax_amount']);
            $item['subtotal_tax_with_currency'] = number_format($item['subtotal_incl_tax']);
            $item['shipping_with_currency'] = number_format($item['shipping_incl_tax']);
            $item['discount_with_currency'] = number_format($item['discount_amount']);
            $item['sales_total_with_currency'] = number_format($item['grand_total']);
            $item['refunded_with_currency'] = number_format($item['total_refunded']);
            array_push($list, $item);
        }
        return $list;
    }

    public function getOrderLink($collection)
    {
        $list = [];
        foreach ($collection as $order) {
            $order['link'] = $this->orderInfo->getViewUrl($order['order_id']);
            array_push($list, $order);
        }
        return $list;
    }
}
