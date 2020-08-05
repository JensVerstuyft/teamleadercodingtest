# Teamleader discount coding test

## Usage

Clone this repo in the project folder initialize composer:

```
composer install
```

Start the webserver on local environment:
```
php -S localhost:8000 -t public
```

To test the discounts added on a given order, Make a POST request to following url with an "order" parameter containing a json formatted order as givin in example.

POST http://localhost:8000/discount/calculate

"order": {
  "id": "1",
  "customer-id": "1",
  "items": [
    {
      "product-id": "B102",
      "quantity": "10",
      "unit-price": "4.99",
      "total": "49.90"
    }
  ],
  "total": "49.90"
}

The service will return which discounts were applied and update the total of the order accordingly. 

## Tests
There are 3 tests for 3 example orders set up.
You can run them with phpunit.

```
./vendor/bin/phpunit tests
```