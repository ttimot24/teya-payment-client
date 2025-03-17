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

        $client = new Ttimot24\TeyaPayment\TeyaApiClient();
        $response = $client->payment($payment);
        $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

    public function testGetTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaApiClient();
        $response = $client->transaction(1);
        $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

}