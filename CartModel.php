<?php
require_once __DIR__ . '/../core/db.php';

class CartModel
{
    public function addOrIncrementProduct(?productID)
    {
        $conn = getDbConnection();
        $productID = (int)$productID;

        $selQuery = "SELECT Quantity FROM cart WHERE ProductID = $productID";
        $result = mysqli_query($conn, $selQuery);

        if ($row = mysqli_fetch_assoc($result)) {
            $newQty = $row['Quantity'] + 1;
            $updQuery = "UPDATE cart SET Quantity = $newQty WHERE ProductID = $productID";
            mysqli_query($conn, $updQuery);
        } else {
            $insQuery = "INSERT INTO cart (ProductID, Quantity) VALUES ($productID, 1)";
            mysqli_query($conn, $insQuery);
        }
    }
    public function decrementProduct($productID)
    {
        $conn = getDbConnection();
        $productID = (int)$productID;

        $selQuery = "SELECT Quantity FROM cart WHERE ProductID = $productID";
        $result = mysqli_query($conn, $selQuery);

        if ($row = mysqli_fetch_assoc($result)) {
            $newQty = $row['Quantity'] - 1;
            if ($newQty <= 0) {
                mysqli_query($conn, "DELETE FROM cart WHERE ProductID = $productID");
            } else {
                mysqli_query($conn, "UPDATE cart SET Quantity = $newQty WHERE ProductID = $productID");
            }
        }
    }

    public function removeProduct($productID)
    {
        $conn = getDbConnection();
        mysqli_query($conn, "DELETE FROM cart");
    }

    public function getCartItemsWithTotals()
    {
        $conn = getDbConnection();

        $query = "SELECT p.ProductID, p.ProductName, p.ProductCost, c.Quantity
        FROM cart c
        INNER JOIN products p ON c.ProductID = p.ProductID
        WHERE c.Quantity >= 1
        ORDER BY p.ProductID";

        $result = mysqli_query($conn, $query);

        $items = [];
        $subtotal = 0.0;

        while ($row = mysqli_fetch_assoc($result)) {
            $productTotal = $row['ProductCost'] * $row['Quantity'];
            $subtotal += $productTotal;

            $items[] = [
                'ProductID' => $row['ProductID'],
                'ProductName' => $row['ProductName'],
                'ProductCost' => $row['ProductCost'],
                'Quantity' => $row['Quantity'],
                'ProductTotal' => $productTotal
            ];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $subtotal * 0.05,
            'shipping' => $subtotal * 0.10,
            'orderTotal' => $subtotal * 1.15
        ];
    }
}