<?php 

namespace Ttimot24\TeyaPayment;

class TeyaApiClient extends TeyaClientBase
{

    protected $defaultConfig = [
        'environment' => 'sandbox',
        ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ODU2MjkzX3ByMGx4blc4UEcxU2VDd1ZKM1dQSDBsWENlVTAvc1lMdFg6'
            ]
        ]
    ];

    public function getEnvironmentUri(){
        return $this->environments[$this->mergedConfig['environment']];
    }

    public function preAuthorization(array $data){

        $data['TransactionType'] = "PreAuthorization";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(trim("/rpgapi/api/payment"), $data);

        return $response->getBody();
    }

    public function payment(array $data){

        $data['TransactionType'] = "Sale";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(trim("/rpgapi/api/payment"), $data);

        return $response->getBody();
    }

    public function transaction($id){

        $response = $this->http->get("/rpgapi/api/payment/".$id);

        return $response->getBody();
    }

    public function cancel(){
        
    }

    public function refund(){
        
    }

    public function capture(){
        
    }
}