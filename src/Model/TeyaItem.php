<?php 

namespace Ttimot24\TeyaPayment\Model;

class TeyaItem {

    private string $description;
    private int $count;
    private float $price;

    public function __construct(string $description, int $count, float $price)
    {
        $this->description = $description;
        $this->count = $count;
        $this->price = $price;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getCount(): int {
        return $this->count;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getTotal(): float {
        return $this->price * $this->count;
    }

    public function toArray(): array {
        return [
            'description' => $this->description,
            'count' => $this->count,
            'unitamount' => $this->price
        ];
    }   

}