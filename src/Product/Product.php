<?php
namespace Ecommerce\Product;

class Product
{
    public function __construct(
        private string $id,
        private string $name,
        private float $price
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
