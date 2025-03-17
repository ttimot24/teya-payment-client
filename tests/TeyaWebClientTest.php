<?php 

use PHPUnit\Framework\TestCase;

class TeyaWebClientTest extends TestCase {

    public function testSignatureCalulation(){
        $client = new Ttimot24\TeyaPayment\TeyaWebClient(['MerchantId' => '9123456', 'PaymentGatewayId' => 7, 'SecretKey' => '1234567890abcdef']);
        $checkHash = $client->getSignature([
            "amount" => 100,
            "language" => "HU",
            "currency" => "ISK",
            "orderid" => "TEST00000001"
        ]);

        $this->assertEquals("ef2e66e64df91143e7e98ecc9f94e12988718408b860770b4181e466401f22d0", $checkHash);
    }

    /*public function testStartTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaWebClient(['MerchantId' => '9123456', 'PaymentGatewayId' => 7, 'SecretKey' => '1234567890abcdef']);
        $response = $client->start([
            "amount" => 100,
            "language" => "HU",
            "currency" => "HUF",
            "orderid" => "TEST00000001"
        ]);
    //    $this->assertEquals('{"id":1,"status":"success"}', $response);
    }*/

}