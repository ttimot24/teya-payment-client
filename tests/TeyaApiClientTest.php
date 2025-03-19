<?php 

use PHPUnit\Framework\TestCase;

class TeyaApiClientTest extends TestCase {

    private $client;

    private $payment = [
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

    public function setUp(): void {

        $this->client = new Ttimot24\TeyaPayment\TeyaApiClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'log_enabled' => true, 'log_level' => 'debug']);

    }

    public function testPreAuthorization(){


        $response = $this->client->preauth($this->payment);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testPayment(){

        $response = $this->client->payment($this->payment);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testTransaction(){

        $response = $this->client->transaction('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCapture(){

        $response = $this->client->capture('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');
        $this->assertNotNull($response->getStatusCode());
    }

    public function testCancel(){

        $response = $this->client->cancel('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');
        $this->assertNotNull($response->getStatusCode());
    }

    public function testRefund(){

        $response = $this->client->refund('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');
        $this->assertNotNull($response->getStatusCode());
    }

}