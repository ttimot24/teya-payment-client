<?php 

namespace Ttimot24\TeyaPayment\Model;

abstract class TeyaMessageInterface {

    public function __construct(array $content)
    {
        foreach($content as $key => $value){
            $this->{lcfirst($key)} = $value;
        }
    }

}