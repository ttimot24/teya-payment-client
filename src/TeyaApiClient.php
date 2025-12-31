<?php 

namespace Ttimot24\TeyaPayment;

use \GuzzleHttp\RequestOptions;

class TeyaApiClient extends TeyaClientBase
{

    private static string $_PAYMENT_ENDPOINT = "/rpg/api/payment";

    protected array $rules = ['PrivateKey'];

    protected array $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ];

    private function initialize(array $data): array {
        $data['OrderId']? : $data['OrderId'] = $this->generateOrderId();
        $data['TransactionDate']? : $data['TransactionDate'] = date("c");
        return $data;
    }

    public function preauth(array $data){

        $data['TransactionType'] = "PreAuthorization";
        $data = $this->initialize($data);

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, [RequestOptions::JSON => $data, RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function payment(array $data){

        $data['TransactionType'] = "Sale";
        $data = $this->initialize($data);

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, [RequestOptions::JSON => $data, RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function transaction($id){

        $response = $this->http->get(self::$_PAYMENT_ENDPOINT."/".$id, [RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function capture($id){
        $response = $this->http->put(self::$_PAYMENT_ENDPOINT."/".$id."/capture", [RequestOptions::JSON => [], RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function cancel($token){
        $response = $this->http->delete('/rpg/api/token/single/'.$token, [RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function refund($id){
        $response = $this->http->put(self::$_PAYMENT_ENDPOINT."/".$id."/refund", [RequestOptions::JSON => [], RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }


}