<?php
namespace Ecommerce\Cart;

use Ecommerce\Product\Product;
class CartItem
{
    private int $quantity;

    public function __construct(private Product $product)
    {
        $this->quantity = 1;
    }

    public function incrementQuantity(): void
    {
        $this->quantity++;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->product->getPrice();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
