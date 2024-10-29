<?php
namespace Ecommerce\Discount;



use Ecommerce\Cart\Cart;

class QuantityDiscount implements DiscountInterface
{
    public function calculateDiscount(Cart $cart): float
    {
        $discount = 0.0;
        foreach ($cart->getItems() as $item) {
            $discount += floor($item->getQuantity() / 5) * $item->getProduct()->getPrice();
        }
        return $discount;
    }
}
