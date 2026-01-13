<?php
//front controller for store

//determine which page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'catalog';

switch ($page) {

    case 'cart':
        require_once __DIR__ . '/controllers/CartController.php';
        $controller = new CartController();
        $controller->handleRequest();
    break;

    case 'catalog':
        default:
        require_once __DIR__ . '/controllers/CatalogController.php';
        $controller = new CatalogController();
        $controller->handleRequest();
    break;
}