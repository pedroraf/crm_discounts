<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 15:30
 */

namespace Order;

class Order
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $customer_id;

    /**
     * @var array
     */
    public $items;

    /**
     * @var float
     */
    public $total;

    /**
     * @var float
     */
    public $total_discount = 0;
    public $customer_discount;
    public $items_discount;
    /**
     * Order constructor.
     * @param $order string | object
     */
    public function __construct($order = null)
    {
        if (is_string($order)) {
            $order = json_decode($order);
        }

        if (is_object($order)) {
            $this->id = $order->id;
            $this->customer_id = $order->{'customer-id'};
            $this->items = $order->items;
            $this->total = $order->total;
        }
    }
}
