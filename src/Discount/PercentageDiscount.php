<?php
namespace Ecommerce\Discount;

use Ecommerce\Cart\Cart;

class PercentageDiscount implements DiscountInterface
{
    private float $threshold;
    private float $discountRate;

    public function __construct(float $threshold = 100.0, float $discountRate = 0.10)
    {
        $this->threshold = $threshold;
        $this->discountRate = $discountRate;
    }

    public function calculateDiscount(Cart $cart): float
    {
        return $cart->getTotalAmountBeforeDiscount() > $this->threshold ? $cart->getTotalAmountBeforeDiscount() * $this->discountRate : 0.0;
    }
}
