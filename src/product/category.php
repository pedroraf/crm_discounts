<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 16:51
 */

namespace Product;

use Common\ArrayUtils;

class Category
{
    public $id;
    public $name;
    public $discount_type;
    public $value;

    public function __construct($data = null)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }

        if (is_object($data)) {
            $vars = get_object_vars($data);
            foreach ($vars as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @param $id int
     * @return Category
     */
    public static function getCategoryById($id)
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/categories.json'));
        $category = ArrayUtils::objArraySearch($data, 'id', $id);

        return new Category($category);
    }
}
