<?php
//connect to database
$hostname = "localhost";
$username = "vicfly5850";
$password = "Password1";
$dbname = "310project";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

//variables to determine the type of operation
$add = false;
$remove = false;
$inc = false;
$dec = false;

//handle actions if submitted
if (isset($_POST['product_id'])) {
    $productID = (int)$_POST['product_id'];
    $add = isset($_POST['add']);
    $remove = isset($_POST['remove']);
    $inc = isset($_POST['inc']);
    $dec = isset($_POST['dec']);

    if ($add || $inc) {
        //increase quantity by 1; if not in cart, insert with quantity 1
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

        header("Location: cart.php");
        exit();
    }
    else if ($dec) {
        //decrease quantity by 1, but do not go below 0
        $selQuery = "SELECT Quantity FROM cart WHERE ProductID = $productID";
        $result = mysqli_query($conn, $selQuery);
        if ($row = mysqli_fetch_assoc($result)) {
            $newQty = $row['Quantity'] - 1;
            if ($newQty <= 0) {
                //either delete or set to 0
                $delQuery = "DELETE FROM cart WHERE ProductID = $productID";
                mysqli_query($conn, $delQuery);
            } else {
                $updQuery = "UPDATE cart SET Quantity = $newQty WHERE ProductID = $productID";
                mysqli_query($conn, $updQuery);
            }
        }

        header("Location: cart.php");
        exit();
    }
    else if ($remove) {
        //remove product from cart
        $delQuery = "DELETE FROM cart WHERE ProductID = $productID";
        mysqli_query($conn, $delQuery);

        header("Location: cart.php");
        exit();
    }
}

//query all products with the current cart quantity
$query = "SELECT p.ProductID, p.ProductName, p.ProductDescription, p.ProductCost,
IFNULL(c.Quantity, 0) AS Quantity
FROM products p
LEFT JOIN cart c ON p.ProductID = c.ProductID
ORDER BY p.ProductID";
$result = mysqli_query($conn, $query);
?>

<style>
table {
    border-spacing: 5px;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    text-align: center;
}
th {
    background-color: lightskyblue;
}
tr:nth-child(even) {
    background-color: lightgray;
}
</style>

<html>
<body>
<h2>Product Catalog</h2>

<table>
<tr style="font-size:large;">
<th>Product ID</th>
<th>Product Name</th>
<th>Description</th>
<th>Cost</th>
<th>Quantity in Cart</th>
<th>Add</th>
<th>Remove</th>
<th>Increase</th>
<th>Decrease</th>
</tr>

<?php while($row = mysqli_fetch_array($result)): ?>
    <tr>
        <td><?php echo $row["ProductID"]; ?></td>
        <td><?php echo $row["ProductName"]; ?></td>
        <td><?php echo $row["ProductDescription"]; ?></td>

        <td><?php echo "$" . number_format($row["ProductCost"], 2); ?></td>
        <td><?php echo $row["Quantity"]; ?></td>

        <td>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="add" value="Add to Cart">
            </form>
        </td>
        <td>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="remove" value="Remove From Cart">
            </form>
        </td>
        <td>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="inc" value="+">
            </form>   
        <td>
        <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="dec" value="-">
            </form>
        </td>
    </tr>
<?php endwhile; ?>
</table>

<br>
<form method="GET" action="cart.php">
    <input type="submit" value="View Cart">
</form>

</body>
</html>