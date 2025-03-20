<?php 

namespace Ttimot24\TeyaPayment\Model;

class TeyaItem {

    private $description;
    private $count;
    private $price;

    public function __construct(string $description, int $count, float $price)
    {
        $this->description = $description;
        $this->count = $count;
        $this->price = $price;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getCount(){
        return $this->count;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getTotal(){
        return $this->price * $this->count;
    }

    public function toArray(){
        return [
            'description' => $this->description,
            'count' => $this->count,
            'unitamount' => $this->price
        ];
    }   

}