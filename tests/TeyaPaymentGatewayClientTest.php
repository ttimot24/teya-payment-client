<?php 

use PHPUnit\Framework\TestCase;

class TeyaPaymentGatewayClientTest extends TestCase {

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

        $client = new Ttimot24\TeyaPayment\TeyaPaymentGatewayClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'log_enabled' => true, 'log_level' => 'debug']);

        $response = $client->payment($payment);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('{"TransactionId":"tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g","TransactionType":"Sale","Amount":100,"Currency":"352","TransactionDate":"2025-03-18T22:51:36+00:00","OrderId":"ORDER1230001","AuthCode":"082996","ActionCode":"000","TransactionStatus":"Accepted","PaymentMethod":{"PaymentType":"Card","PAN":"417666******0104","ExpYear":"2031","ExpMonth":"12","CardType":"Visa"}}', $response->getBody()->getContents());
    }

    public function testGetTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaPaymentGatewayClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'log_enabled' => true, 'log_level' => 'debug']);
        $response = $client->transaction('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');
        $this->assertEquals('{"id":1,"status":"success"}', $response->getBody()->getContents());
    }

}