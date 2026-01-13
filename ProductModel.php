<?php
require_once __DIR__ . '/../core/db.php';

class ProductModel
{
    public function getAllProductsWithCartQuantities()
    {
        $conn = getDbConnection();

        $query = "SELECT p.ProductID, p.ProductName, p.ProductDescription, p.ProductCost,
        IFNULL(c.Quantity, 0) AS Quantity
        FROM products p
        LEFT JOIN cart c ON p.ProductID = c.ProductID
        ORDER BY p.ProductID";

        $result = mysqli_query($conn, $query);

        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }
}