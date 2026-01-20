<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class CatalogController
{
    private $productModel;
    private $cartModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_MEETHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productID = (int)$_POST['product_id'];

            if (isset($_POST['add']) || isset($_POST['inc'])) {
                $this->cartModel->addOrIncrementProduct($productID);
                header("Location: index.php?page=cart");
                exit();
            }

            if (isset($_POST['dec'])) {
                $this->cartModel->decrementProduct($productID);
                header("Location: index.php?page=cart");
                exit();
            }
            if (isset($_POST['remove'])) {
                $this->cartModel->removeProduct($productID);
                header("Location: index.php?page=cart");
                exit();
            }
        }

        $products = $this->productModel->getAllProductsWithCartQuantities();
        include __DIR__ . '/../views/catalog.view.php';
    }
}