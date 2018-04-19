<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 16:21
 */

namespace Product;

use Common\ArrayUtils;

class Product
{
    public $id;
    public $description;

    /**
     * @var Category
     */
    public $category;

    /**
     * @var float
     */
    public $price;

    public function __construct($data = null)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }

        if (is_object($data)) {
            $vars = get_object_vars($data);
            foreach ($vars as $name => $value) {
                if ($name == 'category' && is_numeric($value)) {
                    $this->$name = Category::getCategoryById($value);
                } else {
                    $this->$name = $value;
                }
            }
        }
    }

    /**
     * @param $id string
     * @return Product
     */
    public static function getProductById($id)
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/products.json'));
        $product = ArrayUtils::objArraySearch($data, 'id', $id);

        return new Product($product);
    }
}
