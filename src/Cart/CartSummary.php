<?php
namespace Ecommerce\Cart;

class CartSummary
{
    public function __construct(
        private float $totalBeforeDiscount,
        private float $discount,
        private float $totalAfterDiscount
    ) {}

    public function getTotalBeforeDiscount(): float
    {
        return $this->totalBeforeDiscount;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function getTotalAfterDiscount(): float
    {
        return $this->totalAfterDiscount;
    }
}
