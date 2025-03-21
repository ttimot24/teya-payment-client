

![teya logo](https://helpcenter.teya.com/hc/theming_assets/01J9VB48TBE0YGHF1VWP7R6266)

# Teya Payment PHP Client Library
Teya PHP Client Library is a PHP package designed to interact with the Teya API, enabling seamless integration of Teya's services into PHP applications. It provides a structured and easy-to-use interface for making API requests, handling authentication, and managing data exchanges. The library simplifies complex API interactions by offering pre-built methods for common operations, ensuring developers can efficiently integrate Teya's features with minimal effort. Ideal for businesses and developers looking to incorporate Teya's payment and transactional services into their PHP-based systems.

[https://teya.com](https://teya.com)

### Install
```sh
composer require ttimot24/teya-payment-client
```

### RPG Payment Gateway
```php
$client = new Ttimot24\TeyaPayment\TeyaPaymentGatewayClient([
    'PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX'
    ]);

$client->payment([
        'Amount' => 100,
        'Currency' => 352,
        'OrderId' => 'ORDER1230001',
        'PaymentMethod' => [
            'PaymentType' => 'Card',
            'PAN' => '4176669999000104',
            'ExpYear' => 2031,
            'ExpMonth' => 12
        ]
    ]);

```

### SecurePay
```php
        $client = new Ttimot24\TeyaPayment\TeyaSecurePayClient([
            'MerchantId' => '9256684', 
            'PaymentGatewayId' => 7, 
            'SecretKey' => 'cdedfbb6ecab4a4994ac880144dd92dc',
            'RedirectSuccess' => '/SecurePay/SuccessPage.aspx',
            'RedirectSuccessServer' => 'SUCCESS_SERVER',
            "Currency" => "HUF"
        ]);

        $this->client->addItems([
            new \Ttimot24\TeyaPayment\Model\TeyaItem('Test Item', 1, 10000)
        ]);

        //prepare transaction and redirect user
        $response = $this->client->start([
            "orderid" => "TEST00000001",
        ]);

        header('Location: '.$response['paymentUrl']);
      
        //or a shortcut:
        $this->client->open([
            "orderid" => "TEST00000001",
        ]);

```

### Logging
```php
 $logger = new Logger('TeyaSecurePayClient');
 $logger->pushHandler(new StreamHandler('teya_secure_pay_client.log'), \Monolog\Level::Debug);

 $client = new Ttimot24\TeyaPayment\TeyaPaymentGatewayClient([
            'PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX'
            'logger' => $logger
        ]);
```

### SecurePay Playground
```sh
playground.php
```

### Contribution
Contributions are welcome! If you'd like to improve this project, fork the repository, create a new branch, and submit a pull request. Please follow best practices and ensure your code is clean and well-documented.  