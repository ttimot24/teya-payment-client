<?php 

use PHPUnit\Framework\TestCase;

class TeyaApiClientTest extends TestCase {

    public function testCreateTransaction(){

        $payment = [
            'Amount' => 100,
            'Currency' => 352,
            'OrderId' => 'TEST00000001',
            'PaymentMethod' => [
                'PaymentType' => 'Card',
                'PAN' => '4242424242424242',
                'ExpYear' => 2020,
                'ExpMonth' => 01
            ]
        ];

        $client = new Ttimot24\TeyaPayment\TeyaApiClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX']);

        $response = $client->payment($payment);
        $this->assertEquals('{"id":1,"status":"success"}', $response->getBody()->getContents());
    }

    public function testGetTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaApiClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX']);
        $response = $client->transaction('TEST00000001');
        $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

}