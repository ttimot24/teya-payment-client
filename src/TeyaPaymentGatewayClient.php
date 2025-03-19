<?php 

namespace Ttimot24\TeyaPayment;

use \Psr\Http\Message\ResponseInterface;
use Ttimot24\TeyaPayment\Model\TeyaMessageInterface;
use Ttimot24\TeyaPayment\Model\TeyaTransactionMessage;
use Ttimot24\TeyaPayment\Model\TeyaErrorMessage;

class TeyaPaymentGatewayClient extends TeyaApiClient
{

    private function isSuccessfulTransactionCall(ResponseInterface $response): bool {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    private function deserialize(ResponseInterface $response, $class){

        $array = json_decode($response->getBody()->__toString(), true, 512, JSON_THROW_ON_ERROR);

        return $this->isSuccessfulTransactionCall($response)? new $class($array) : new TeyaErrorMessage($array);
    }

    public function preauth(array $data): TeyaMessageInterface {

        return $this->deserialize(parent::preauth($data), TeyaTransactionMessage::class);
    }

    public function payment(array $data){

        return $this->deserialize(parent::payment($data), TeyaTransactionMessage::class);
    }

    public function transaction($id){

        return $this->deserialize(parent::transaction($id), TeyaTransactionMessage::class);
    }

    public function capture($id){
        return $this->deserialize(parent::capture($id), TeyaTransactionMessage::class);
    }

    public function cancel($token){
        return $this->deserialize(parent::cancel($token), TeyaTransactionMessage::class);
    }

    public function refund($id){
        return $this->deserialize(parent::refund($id), TeyaTransactionMessage::class);
    }


}