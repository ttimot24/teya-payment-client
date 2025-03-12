<?php 

use PHPUnit\Framework\TestCase;

class TeyaClientTest extends TestCase {

    public function testGetTransaction(){

        $client = new Ttimot24\TeyaPayment\TeyaClient();
        $response = $client->transaction(1);
        $this->assertEquals('{"id":1,"status":"success"}', $response);
    }

}