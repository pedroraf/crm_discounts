<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 17:26
 */

namespace Order;

class Item
{
    public $product_id;
    public $quantity;
    public $unit_price;
    public $total;

    public $quantity_free = 0;
    public $discount = 0;

    public function __construct($data = null)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }

        if (is_object($data)) {
            $vars = get_object_vars($data);
            foreach ($vars as $name => $value) {
                $name = str_replace('-', '_', $name);
                $this->$name = $value;
            }
        }
    }
}
