<?php 

use PHPUnit\Framework\TestCase;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TeyaSecurePayClientTest extends TestCase {

    private $client;

    protected function setUp(): void {


        $logger = new Logger('TeyaSecurePayClient');
        $logger->pushHandler(new StreamHandler('teya_secure_pay_client.log'), \Monolog\Level::Debug);


        $this->client = new Ttimot24\TeyaPayment\TeyaSecurePayClient([
            'MerchantId' => '9256684', 
            'PaymentGatewayId' => 7, 
            'SecretKey' => 'cdedfbb6ecab4a4994ac880144dd92dc',
            'RedirectSuccess' => 'https://test/SecurePay/SuccessPage.aspx',
            'RedirectSuccessServer' => 'https://test/SecurePay/SuccessServerPage.aspx',
            "Currency" => "HUF",
            "logger" => $logger
        ]);

    }

    public function testSignatureCalulation(){

        $signatureClient = new Ttimot24\TeyaPayment\TeyaSecurePayClient([
            'MerchantId' => '9123456', 
            'PaymentGatewayId' => 16, 
            'SecretKey' => '1234567890abcdef',
            'RedirectSuccess' => 'https://borgun.is/success',
            'RedirectSuccessServer' => 'https://borgun.is/success_server'
        ]);


        $checkHash = $signatureClient->getSignature([
            "amount" => 100,
            "currency" => "ISK",
            "orderid" => "TEST00000001"
        ]);

        $this->assertEquals("ef2e66e64df91143e7e98ecc9f94e12988718408b860770b4181e466401f22d0", $checkHash);
    }

    public function testSignatureValidation(){

        $validation = $this->client->validateSignature([
            "orderhash" => "f92204b4355704cb91b29fd059089433c224e47666b11e2ee674446ce0169e46",
            "amount" => 2000,
            "currency" => "HUF",
            "orderid" => "ASD1ASD1"
        ]);

        $this->assertTrue($validation);
    }

    public function testStartTransaction(){

        $this->client->addItems([
            new \Ttimot24\TeyaPayment\Model\TeyaItem('Test Item', 1, 10000)
        ]);

        $response = $this->client->start([
            "orderid" => "TEST00000001",
        ]);

        $this->assertArrayHasKey('ret', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['ret'], $response['message']);
        $this->assertEquals('', $response['message']);
        $this->assertArrayHasKey('ticket', $response);
        $this->assertArrayHasKey('redirect_url', $response);

    }

}