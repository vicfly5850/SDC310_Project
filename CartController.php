<?php
require_once __DIR__ . '/../models/CartModel.php';

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
            $this->cartModel->clearCart();
            header("Location: index.php?page=catalog");
            exit();
        }

        $cartData = $this->cartModel->getCartItemsWithTotals();

        $items = $cartData['items'];
        $items = $cartData['subtotal'];
        $items = $cartData['tax'];
        $items = $cartData['shipping'];
        $items = $cartData['orderTotal'];

        include __DIR__ . '/../views/cart.view.php';
    }
}