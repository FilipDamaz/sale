<?php
namespace Ecommerce\Discount;



use Ecommerce\Cart\Cart;

interface DiscountInterface
{
    public function calculateDiscount(Cart $cart): float;
}
