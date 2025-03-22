<?php 

use PHPUnit\Framework\TestCase;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TeyaPaymentGatewayClientTest extends TestCase {

    private $client;

    private $payment = [
        'Amount' => 100,
        'Currency' => 352,
        'PaymentMethod' => [
            'PaymentType' => 'Card',
            'PAN' => '4176669999000104',
            'ExpYear' => 2031,
            'ExpMonth' => 12
        ]
    ];

    public function setUp(): void {

        $logger = new Logger('TeyaSecurePayClient');
        $logger->pushHandler(new StreamHandler('teya_secure_pay_client.log'), \Monolog\Level::Debug);

        $this->client = new Ttimot24\TeyaPayment\TeyaPaymentGatewayClient(['PrivateKey' => '856293_pr0lxnW8PG1SeCwVJ3WPH0lXCeU0/sYLtX', 'logger' => $logger]);

    }

    public function testPreAuthorization(){

        $message = $this->client->preauth($this->payment);

        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertNotNull($message->getTransactionStatus());
    }

    public function testPayment(){

        $message = $this->client->payment($this->payment);
        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertNotNull($message->getTransactionStatus());
    }

    public function testTransaction(){

        $message = $this->client->transaction('tr_29yag5DnGmMAsl-F79Xiomz2UxPpaX_g');

        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertNotNull($message->getTransactionStatus());
    }

    public function testCapture(){

   /*     $this->payment['OrderId']='CAPTR1230001';

        $preauth = $this->client->preauth($this->payment);
        $message = $this->client->capture($preauth->getTransactionId());
        var_dump($message);
        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertEquals("Captured", $message->getTransactionStatus()); */
    }

    public function testCancel(){

    /*    $preauth = $this->client->preauth($this->payment);
        $message = $this->client->cancel($preauth->getTransactionId());
        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertEquals("Cancelled", $message->getTransactionStatus()); */
    }

    public function testRefund(){

    /*    $preauth = $this->client->preauth($this->payment);
        $message = $this->client->refund($preauth->getTransactionId());
        $this->assertInstanceOf(\Ttimot24\TeyaPayment\Model\TeyaTransactionMessage::class, $message);
        $this->assertEquals("Refunded", $message->getTransactionStatus()); */
    }

}