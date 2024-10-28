<?php
include 'db_conn.php';

// ambil product
$productSql = "SELECT id, name, price FROM product";
$productResult = $conn->query($productSql);

$orderSubmitted = false; // submit product

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderNum = $_POST['orderNum'];
    $customerRef = $_POST['customerRef'];
    $orderDate = $_POST['orderDate'];

    // save  order to salesOrder table
    $sqlOrder = "INSERT INTO salesorder (orderNum, customerRef, orderDate) 
                 VALUES ('$orderNum', '$customerRef', '$orderDate')";

    if ($conn->query($sqlOrder) === TRUE) {
        $orderId = $conn->insert_id;
        
        foreach ($_POST['product'] as $key => $productId) {
            $qty = $_POST['qty'][$key];
            $discount = $_POST['discount'][$key];

            // insert order detail
            $sqlDetail = "INSERT INTO orderDetail (orderId, productId, qty, discount) 
                          VALUES ('$orderId', '$productId', '$qty', '$discount')";
            if ($conn->query($sqlDetail) !== TRUE) {
                echo "Error: " . $conn->error;
            }
        }

        // query for the order summary
        $sqlDisplay = "SELECT od.productId, od.qty, od.discount, p.price,
                       (od.qty * p.price * (1 - od.discount / 100)) AS subtotal,
                       p.name AS productName
                       FROM orderDetail od
                       JOIN product p ON od.productId = p.id
                       WHERE od.orderId = '$orderId'";

        $result = $conn->query($sqlDisplay);
        $orderSubmitted = true;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Sales Order</title>
    <link rel="stylesheet" href="salesOrder.css">
</head>
<body>
    <div class="container">
        <h2>Customer Sales Order</h2>
        <form method="POST" action="">
            <label>Order Number:</label>
            <input type="text" name="orderNum" required><br>

            <label>Customer Ref:</label>
            <input type="text" name="customerRef" required><br>

            <label>Order Date:</label>
            <input type="date" name="orderDate" required><br><br>

            <h3>Products</h3>
            <div id="product">
                <div class="product-row">
                    <select name="product[]" required>
                        <option value="">Select Product</option>
                        <?php
                        $productResult->data_seek(0);
                        while ($row = $productResult->fetch_assoc()) { ?>
                            <option value="<?= $row['id']; ?>"><?= $row['name']; ?> - <?= $row['price']; ?></option>
                        <?php } ?>
                    </select>

                    <label for="qty">Quantity:</label> 
                    <input type="number" name="qty[]" required>
                    <label for="discount">Discount(%): </label>
                    <input type="number" name="discount[]" value="0" required>
                    <br><br>
                </div>
            </div>

            <button type="button" onclick="addProduct()">Add another product</button><br><br>
            <input type="submit" value="Submit Order">
        </form>
        
        <a href="index.php" class="back-button">Back</a>

        <?php if ($orderSubmitted && $result->num_rows > 0): ?>
            <div class="order-summary">
                <h2>Order Summary</h2>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Discount (%)</th>
                        <th>Sub Total</th>
                    </tr>
                    <?php
                    $total = 0;
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['subtotal'];
                        echo "<tr>
                                <td>" . $row['productName'] . "</td>
                                <td>" . $row['qty'] . "</td>
                                <td>" . number_format($row['price'], 2) . "</td>
                                <td>" . $row['discount'] . "</td>
                                <td>" . number_format($subtotal, 2) . "</td>
                              </tr>";
                        $total += $subtotal;
                    }
                    echo "<tr>
                            <td colspan='4' style='text-align:right;'><strong>Total:</strong></td>
                            <td>" . number_format($total, 2) . "</td>
                          </tr>";
                    ?>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function addProduct() {
            var productRow = document.querySelector(".product-row").cloneNode(true);
            productRow.querySelector("select").selectedIndex = 0;
            productRow.querySelector("input[name='qty[]']").value = '';
            productRow.querySelector("input[name='discount[]']").value = '0';
            document.getElementById("product").appendChild(productRow);
        }
    </script>
</body>
</html>
