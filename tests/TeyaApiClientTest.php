<?php 

use PHPUnit\Framework\TestCase;

class TeyaApiClientTest extends TestCase {

    public function testCreateTransaction(){

        $payment = [
            'Amount' => 100,
            'Currency' => 352,
            'OrderId' => 'ORDER1230001',
            'PaymentMethod' => [
                'PaymentType' => 'Card',
                'PAN' => '4176669999000104',
                'ExpYear' => 2031,
                'ExpMonth' => 12
            ]
        ];

        $client = new Ttimot24\TeyaPayment\TeyaApiClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'log_enabled' => true, 'log_level' => 'debug']);

        $response = $client->payment($payment);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('{"id":1,"status":"success"}', $response->getBody()->getContents());
    }

    public function testGetTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaApiClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'log_enabled' => true, 'log_level' => 'debug']);
        $response = $client->transaction('ORDER1230001');
        $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

}