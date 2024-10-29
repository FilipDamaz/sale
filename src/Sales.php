<?php
namespace Ecommerce;

use Ecommerce\Cart\Cart;
use Ecommerce\Cart\CartSummary;
use Ecommerce\Discount\PercentageDiscount;
use Ecommerce\Discount\QuantityDiscount;
use Ecommerce\Product\Product;

class Sales
{
    private Cart $cart;
    private array $discounts = [];

    public function __construct()
    {
        $this->cart = new Cart();
        $this->discounts[] = new QuantityDiscount();
        $this->discounts[] = new PercentageDiscount();
    }

    public function addProduct(Product $product): void
    {
        $this->cart->addProduct($product);
    }

    public function getBestDiscount(): float
    {
        $maxDiscount = 0.0;
        foreach ($this->discounts as $discount) {
            $maxDiscount = max($maxDiscount, $discount->calculateDiscount($this->cart));
        }
        return $maxDiscount;
    }

    private function calculateCartSummary()
    {
        $totalBeforeDiscount = $this->cart->getTotalAmountBeforeDiscount();
        $bestDiscount = $this->getBestDiscount();
        $totalAfterDiscount = $totalBeforeDiscount - $bestDiscount;

        $CartSummary = new CartSummary($totalBeforeDiscount, $bestDiscount, $totalAfterDiscount);
        $this->cart->setCartSummary($CartSummary);
        $this->cart->setIsModified(false);
    }

    public function getCart() : Cart
    {
        if($this->cart->getIsModified())
        {
            $this->calculateCartSummary();
        }
        return $this->cart;
    }
}
