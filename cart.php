<?php
//connect to database
$hostname = "localhost";
$username = "vicfly5850";
$password = "Password1";
$dbname = "310project";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

//handle checkout (clear cart and go back to catalog)
if (isset($_POST['checkout'])) {
    $clrQuery = "DELETE FROM cart";
    mysqli_query($conn, $clrQuery);

    header("Location: catalog.php");
    exit;
}

//query products in cart (quantity >= 1)
$query = "SELECT p.ProductID, p.ProductName, p.ProductCost, c.Quantity
        FROM cart c
        INNER JOIN products p ON c.ProductID = p.ProductID
        WHERE c.Quantity >= 1
        ORDER BY p.ProductID";
$result = mysqli_query($conn, $query);

//calculate totals
$subtotal = 0.0;
$items = [];

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
//tax: 5%, shipping: 10% of pre-tax total
$tax = $subtotal * 0.05;
$shipping = $subtotal * 0.10;
$orderTotal = $subtotal + $tax + $shipping;
?>

<style>
table {
    border-spacing: 5px;
}
table, th, td {
    border: 1px solid black;
}
th, td {
    padding: 10px;
    text-align: center;
}
th {
    background-color: lightskyblue;
}
tr:nth-child(even) {
    background-color: whitesmoke;
}
tr:nth-child(odd) {
    background-color: lightgray;
}
</style>
<html>
    <head>
        <title>Victoria Flynn SDC310L Project - Cart</title>
    </head>
    <body>
        <h2>Shopping Cart</h2>

        <?php if (count($items) == 0): ?>
            <p>No items in your cart.</p>
        <?php else: ?>
        <table>
            <tr style="font-size:large;">
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity Ordered</th>
            <th>Product Cost</th>
            <th>Product Total</th>
        </tr>

        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo $item['ProductID']; ?></td>
                <td><?php echo $item['ProductName']; ?></td>
                <td><?php echo $item['Quantity']; ?></td>
                <td><?php echo "$" . number_format($item['ProductCost'], 2); ?></td>
                <td><?php echo "$" . number_format($item['ProductTotal'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>

        <br>
        <h3>Order Summary</h3>
        <p>Total of items ordered: <?php echo "$" . number_format($subtotal, 2); ?></p>
        <p>Tax (5%): <?php echo "$" . number_format($tax, 2); ?></p>
        <p>Shipping & Handling (10% of pre-tax total): <?php echo "$" . number_format($shipping, 2); ?></p>
        <p><strong>Order Total: <?php echo "$" . number_format($orderTotal, 2); ?></strong></p>
        <?php endif; ?>

        <br>
        <form method="GET" action="catalog.php">
            <input type="submit" value="Continue Shopping">
        </form>

        <br>
        <form method="POST">
            <input type="submit" name="checkout" value="check out">
        </form>

    </body>
</html>


