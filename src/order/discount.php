<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 15:04
 */

namespace Order;

use Customer\Customer;
use Product\Product;

class Discount
{
    private $messages = [];
    private $total_discount = 0;
    private $categories_discount = [];
    private $items = [];

    /**
     * @param $order Order
     * @return string
     */
    public function calculate(Order $order)
    {
        $customer = Customer::getCustomerById($order->customer_id);
        if ($customer->revenue > 1000) {
            $this->total_discount = 0.1;
            $this->messages[] = "over € 1000, 10% on total";
        }

        foreach ($order->items as $item) {
            $item = new Item($item);
            $product = Product::getProductById($item->product_id);
            $this->calculateForItem($product, $item);
        }

        $items_total = $this->calculateOrderTotal();
        $order->customer_discount = round($items_total * $this->total_discount, 2);
        $order->items_discount = $order->total - $items_total;
        $order->total_discount = $order->customer_discount + $order->items_discount;

        $order->items = $this->items;

        return json_encode([
            'order'=> $order,
            'messages'=> $this->messages
        ]);
    }

    private function calculateForItem(Product $product, Item $item)
    {
        switch ($product->category->discount_type) {
            case '2+ cheapest product':
                $this->categories_discount[$product->category->discount_type][] = $item;
                $this->items[$item->product_id] = $item;
                break;

            case '+1':
                $item->quantity_free = floor($item->quantity / $product->category->value);
                $this->messages[] = "on item " . $product->description . " for each " . $product->category->value . " you get ". $product->category->discount_type;
                $this->items[$item->product_id] = $item;
                break;
        }
    }

    private function calculateOrderTotal()
    {
        $total = 0;
        $cheapest_item = new Item();

        foreach ($this->categories_discount as $category_key => $category_items) {
            if ($category_key == '2+ cheapest product' && count($category_items)>=2) {
                foreach ($category_items as $category_item) {
                    if (is_null($cheapest_item->total) || $category_item->unit_price < $cheapest_item->unit_price) {
                        $cheapest_item = $category_item;
                    }
                }
            }
        }

        foreach ($this->items as &$item) {
            $item = new Item($item);
            if ($item->product_id == $cheapest_item->product_id) {
                $product = Product::getProductById($item->product_id);
                $item->discount = round($item->total * $product->category->value, 2);
                $this->messages[] = "20% discount on item " . $product->description;
            }

            //echo $item->total ."-". $item->discount;
            $total += (($item->total * 1) - $item->discount);
        }
        return round($total, 2);
    }

}
