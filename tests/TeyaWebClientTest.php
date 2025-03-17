<?php 

use PHPUnit\Framework\TestCase;

class TeyaWebClientTest extends TestCase {

    private $client;

    protected function setUp(): void {

        $this->client = new Ttimot24\TeyaPayment\TeyaWebClient([
            'MerchantId' => '9256684', 
            'PaymentGatewayId' => 7, 
            'SecretKey' => 'cdedfbb6ecab4a4994ac880144dd92dc',
            'RedirectSuccess' => 'https:/google.com?q=success',
            'RedirectSuccessServer' => 'https:/google.com?q=successserver'
        ]);

    }

    public function testSignatureCalulation(){

        $checkHash = $this->client->getSignature([
            "amount" => 100,
            "language" => "HU",
            "currency" => "ISK",
            "orderid" => "TEST00000001"
        ]);

        $this->assertEquals("ef2e66e64df91143e7e98ecc9f94e12988718408b860770b4181e466401f22d0", $checkHash);
    }

    public function testStartTransaction(){

        $response = $this->client->start([
            "amount" => 100,
            "language" => "HU",
            "currency" => "HUF",
            "orderid" => "TEST00000001"
        ]);

        echo $response;

    //    $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

}