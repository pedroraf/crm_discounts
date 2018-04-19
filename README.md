# RESTful API

RESTful api built on SlimPHP framework.

## Version
0.0.1

## Installation

Install SlimPHP and dependencies
```
$ composer install
```

## Available API Endpoints - json format expected
```
$ POST /api/order_discount
```

## Run & Test

Use PHP internal server to run the code.
```
php -S localhost:8000
```

Use an app to make your API requests, for example:

https://www.getpostman.com/

Paste your order json and send to the endpoint.
The result is a json object, equal to the original json (all properties are untouched), 
but brings the following extra properties:

### On items:
- quantity_free (number of free items)
- discount (discount applied on the item total)

### On order
- items_discount (discounts applied on items)
- customer_discount (discount applied on total, after items are discounted too)
- total_discount (final discount, that should be deducted from the total property)

### New property messages
- messages (all applied discounts in text format)

### Example return:
```
{
	"order": {
		"id": "3",
		"customer_id": "2",
		"items": {
			"A101": {
				"product_id": "A101",
				"quantity": "2",
				"unit_price": "9.75",
				"total": "19.50",
				"quantity_free": 0,
				"discount": 3.899999999999999911182158029987476766109466552734375
			},
			"A102": {
				"product_id": "A102",
				"quantity": "1",
				"unit_price": "49.50",
				"total": "49.50",
				"quantity_free": 0,
				"discount": 0
			}
		},
		"total": "69.00",
		"total_discount": 10.4100000000000054711790653527714312076568603515625,
		"customer_discount": 6.5099999999999997868371792719699442386627197265625,
		"items_discount": 3.900000000000005684341886080801486968994140625
	},
	"messages": ["over \u20ac 1000, 10% on total", "20% discount on item Screwdriver"]
}
```

