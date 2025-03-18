<?php 

namespace Ttimot24\TeyaPayment;

class TeyaPaymentGatewayClient extends TeyaClientBase
{

    private static $_PAYMENT_ENDPOINT = "/rpg/api/payment";

    protected $rules = ['PrivateKey'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ];

    public function preAuthorization(array $data){

        $data['TransactionType'] = "PreAuthorization";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, ['json' => $data, 'auth' => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function payment(array $data){

        $data['TransactionType'] = "Sale";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, ['json' => $data, 'auth' => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function transaction($id){

        $response = $this->http->get(self::$_PAYMENT_ENDPOINT."/".$id, ['auth' => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function cancel(){
        
    }

    public function refund(){
        
    }

    public function capture(){
        
    }
}