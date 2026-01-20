<?php include __DIR__ . '/layout/header.php'; ?>

<h2>Shopping Cart</h2>

<?php if (count($items) === 0): ?>
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
    <p>Shipping & Handling (10%): <?php echo "$" . number_format($shipping, 2); ?></p>
    <p><strong>Order Total: <?php echo "$" . number_format($orderTotal, 2); ?></strong></p>
<?php endif; ?>

<br>
<form method="GET" action="index.php">
    <input type="hidden" name="page" value="catalog">
    <input type="submit" value="Continue Shopping">
</form>

<br>
<form method="POST" action="index.php?page=cart">
    <input type="submit" name="checkout" value="Check Out">
</form>

<?php include __DIR__ . '/layout/footer.php'; ?>

