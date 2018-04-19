<?php

/**
 * Created by PhpStorm.
 * User: pedrofonseca
 * Date: 19/04/2018
 * Time: 14:05
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/order/order.php';
require __DIR__ . '/src/order/item.php';
require __DIR__ . '/src/order/discount.php';
require __DIR__ . '/src/customer/customer.php';
require __DIR__ . '/src/product/product.php';
require __DIR__ . '/src/product/category.php';
require __DIR__ . '/src/common/array_utils.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$app = new App();

// Discount Route.
$app->post('/api/order_discount', function (Request $request, Response $response) {
    $order = new Order\Order(json_decode($request->getBody()));
    $discount = new Order\Discount();

    $response->withHeader('Content-type', 'application/json');
    $response->getBody()->write($discount->calculate($order));
});

// Root Route.
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("CRM for Discounts");
    return $response;
});

// Test Route.
$app->get('/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
