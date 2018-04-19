<?php
/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 15:52
 */

namespace Customer;

use Common\ArrayUtils;

class Customer
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;


    public $since;

    /**
     * @var float
     */
    public $revenue;

    /**
     * Customer constructor.
     * @param $data string | object
     */
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
     * @return Customer
     */
    public static function getCustomerById($id)
    {
        $customers = json_decode(file_get_contents(__DIR__ . '/../../data/customers.json'));
        $customer = ArrayUtils::objArraySearch($customers, 'id', $id);

        return new Customer($customer);
    }
}
