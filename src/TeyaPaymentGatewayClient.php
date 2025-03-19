<?php 

namespace Ttimot24\TeyaPayment;

use \GuzzleHttp\RequestOptions;

class TeyaPaymentGatewayClient extends TeyaApiClient
{

    private function deserialize($response){
        return json_decode($response->getBody()->__toString(), true);
    }

    public function preauth(array $data){

        return $this->deserialize(parent::preauth($data));
    }

    public function payment(array $data){

        return $this->deserialize(parent::payment($data));
    }

    public function transaction($id){

        return $this->deserialize(parent::transaction($id));
    }

    public function capture($id){
        return $this->deserialize(parent::capture($id));
    }

    public function cancel($token){
        return $this->deserialize(parent::cancel($token));
    }

    public function refund($id){
        return $this->deserialize(parent::refund($id));
    }


}