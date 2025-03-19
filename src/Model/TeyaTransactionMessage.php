<?php 

namespace Ttimot24\TeyaPayment\Model;

class TeyaTransactionMessage extends TeyaMessageInterface {

    protected $transactionId;
    protected $transactionType;
    protected $transactionStatus;
    protected $amount;

    public function getTransactionId(){
        return $this->transactionId;
    }

    public function getTransactionType(){
        return $this->transactionType;
    }

    public function getTransactionStatus(){
        return $this->transactionStatus;
    }

    public function getAmount(){
        return $this->amount;
    }

}