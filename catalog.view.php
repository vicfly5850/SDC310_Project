<?php include __DIR__ . '/layout/header.php'; ?>

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

<?php foreach ($products as $row): ?>
    <tr>
        <td><?php echo $row["ProductID"]; ?></td>
        <td><?php echo $row["ProductName"]; ?></td>
        <td><?php echo $row["ProductDescription"]; ?></td>
        <td><?php echo "$" . number_format($row["ProductCost"], 2); ?></td>
        <td><?php echo $row["Quantity"]; ?></td>

        <td>
            <form method="POST" action="index.php?page=catalog">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="add" value="Add to Cart">
            </form>
        </td>
        <td>
            <form method="POST" action="index.php?page=catalog">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="remove" value="Remove from Cart">
            </form>
        </td>
        <td>
            <form method="POST" action="index.php?page=catalog">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="inc" value="+">
            </form>
        </td>
        <td>
            <form method="POST" action="index.php?page=catalog">
                <input type="hidden" name="product_id" value="<?php echo $row["ProductID"]; ?>">
                <input type="submit" name="dec" value="-">
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<br>
<form method="GET" action="index.php">
    <input type="hidden" name="page" value="cart">
    <input type="submit" value="View Cart">
</form>

<?php include __DIR__ . '/layout/footer.php'; ?>