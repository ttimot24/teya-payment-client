<?php 

namespace Ttimot24\TeyaPayment\Model;

class TeyaErrorMessage extends TeyaMessageInterface {

    protected string $message;

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function getMessage(): string {
        return $this->message;
    }

}