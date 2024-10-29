<?php

use Ecommerce\Discounts\QuantityDiscount;
use Ecommerce\Product\Product;
use Ecommerce\Sales;
use PHPUnit\Framework\TestCase;

class SalesTest extends TestCase
{
    private Sales $sales;

    protected function setUp(): void
    {
        $this->sales = new Sales();
    }

    public function testAddProductIncreasesCartTotal(): void
    {
        $product = new Product("product1","product1", 10.0);
        $this->sales->addProduct($product);

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // Verify the cart total before any discount is applied is correctly updated
        $this->assertEquals(10.0, $cartSummary->getTotalBeforeDiscount());
    }

    public function testQuantityDiscountAppliedCorrectly(): void
    {
        $product = new Product("product2","product2", 20.0);
        for ($i = 0; $i < 5; $i++) {
            $this->sales->addProduct($product);
        }

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // With five products, a quantity discount should apply for one free product (20.0)
        $this->assertEquals(80.0, $cartSummary->getTotalAfterDiscount());
    }

    public function testPercentageDiscountAppliedCorrectly(): void
    {
        $product = new Product("product3","product3", 50.0);
        for ($i = 0; $i < 3; $i++) {
            $this->sales->addProduct($product);
        }

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // Total before discounts: 150.0, with a 10% discount applied: 15.0
        $this->assertEquals(135.0, $cartSummary->getTotalAfterDiscount());
    }

    public function testBestDiscountSelected(): void
    {
        $product = new Product("product4", "product4", 10.0);
        for ($i = 0; $i < 11; $i++) {
            $this->sales->addProduct($product);
        }

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // Total: 110.0, 10% discount = 11.0, quantity discount (2 free products) = 20.0
        // The higher discount (20.0) should be selected
        $this->assertEquals(90.0, $cartSummary->getTotalAfterDiscount());
    }

    public function testOrderSummaryCalculations(): void
    {
        $productA = new Product("A","productA", 30.0);
        $productB = new Product("B","productB",40.0);

        $this->sales->addProduct($productA);
        $this->sales->addProduct($productB);

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // Total before discounts: 70.0, with no discounts applied
        $this->assertEquals(70.0, $cartSummary->getTotalBeforeDiscount());
        $this->assertEquals(70.0, $cartSummary->getTotalAfterDiscount());
    }

    public function testMultipleDiscountsAndSelectionOfBestDiscount(): void
    {
        $product = new Product("C","productC", 25.0);

        for ($i = 0; $i < 6; $i++) {
            $this->sales->addProduct($product);
        }

        $cartSummary = $this->sales->getCart()->getCartSummary();
        // Total: 150.0, 10% discount = 15.0, quantity discount (1 free product) = 25.0
        // The higher discount (25.0) should be applied
        $this->assertEquals(125.0, $cartSummary->getTotalAfterDiscount());
    }

    public function testCartModyfications(): void
    {
        $product = new Product("product4", "product4", 10.0);
        $this->sales->addProduct($product);
        $cartSummaryBeforeModyfication = $this->sales->getCart()->getCartSummary();
        $this->sales->addProduct($product);
        $cartSummaryAfterModyfication = $this->sales->getCart()->getCartSummary();

        $this->assertEquals(10.0, $cartSummaryBeforeModyfication->getTotalAfterDiscount());
        $this->assertEquals(20.0, $cartSummaryAfterModyfication->getTotalAfterDiscount());
    }
}
