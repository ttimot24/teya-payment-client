<?php 

namespace Ttimot24\TeyaPayment\Model;

class TeyaTransactionMessage extends TeyaMessageInterface {

    protected $transactionId;
    protected $transactionType;
    protected $transactionDate;
    protected $transactionStatus;
    protected $amount;
    protected $currency;
    protected $orderId;
    protected $authCode;
    protected $actionCode;
    protected $paymentMethod;

    public function getTransactionId(){
        return $this->transactionId;
    }

    public function getTransactionType(){
        return $this->transactionType;
    }

    public function getTransactionDate(){
        return $this->transactionDate;
    }

    public function getTransactionStatus(){
        return $this->transactionStatus;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function getCurrency(){
        return $this->currency;
    }

    public function getOrderId(){
        return $this->orderId;
    }

    public function getAuthCode(){
        return $this->authCode;
    }

    public function getActionCode(){
        return $this->actionCode;
    }

    public function getPaymentMethod(){
        return $this->paymentMethod;
    }
    
}