<?php

namespace Ecommerce\Cart;



use Ecommerce\Product\Product;

class Cart
{
    private array $items = [];
    private bool $isModified = true;


    public function addProduct(Product $product): void
    {
        $productId = $product->getId();
        if (!isset($this->items[$productId])) {
            $this->items[$productId] = new CartItem($product);
        } else {
            $this->items[$productId]->incrementQuantity();
        }
        $this->isModified=true;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotalAmountBeforeDiscount(): float
    {
        return array_sum(array_map(
            fn($item) => $item->getTotalPrice(),
            $this->items
        ));
    }


    public function getCartSummary() : CartSummary
    {
        return $this->cartSummary;
    }

    public function setCartSummary(CartSummary $cartSummary)
    {
        $this->cartSummary = $cartSummary;
    }
    public function setIsModified(bool $bool)
    {
        $this->isModified = $bool;
    }

    public function getIsModified() : bool
    {
       return $this->isModified;
    }
}
