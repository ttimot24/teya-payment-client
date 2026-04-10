<?php 

namespace Redwello\TeyaPayment;

use GuzzleHttp\Psr7\Request;

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

        $response = $this->http->sendRequest(new Request(
            'POST',
            $this->getEnvironmentUri() . self::$_PAYMENT_ENDPOINT,
            [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ],
            json_encode($data)
        ));
        
        return $response;
    }

    public function payment(array $data){

        $data['TransactionType'] = "Sale";
        $data = $this->initialize($data);

        $response = $this->http->sendRequest(new Request(
            'POST',
            $this->getEnvironmentUri() . self::$_PAYMENT_ENDPOINT,
            [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ],
            json_encode($data)
        ));

        return $response;
    }

    public function transaction($id){

        $response = $this->http->sendRequest(new Request(
            'GET',
            $this->getEnvironmentUri() . self::$_PAYMENT_ENDPOINT."/".$id,
            [
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ]
        ));

        return $response;
    }

    public function capture($id){

        $response = $this->http->sendRequest(new Request(
            'PUT',
            $this->getEnvironmentUri() . self::$_PAYMENT_ENDPOINT."/".$id."/capture",
            [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ]
        ));

        return $response;
    }

    public function cancel($token){

        $response = $this->http->sendRequest(new Request(
            'DELETE',
            $this->getEnvironmentUri() . '/rpg/api/token/single/'.$token,
            [
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ]
        ));

        return $response;
    }

    public function refund($id){

        $response = $this->http->sendRequest(new Request(
            'PUT',
            $this->getEnvironmentUri() . self::$_PAYMENT_ENDPOINT."/".$id."/refund",
            [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getConfig('PrivateKey') . ':')
            ]
        ));

        return $response;
    }


}