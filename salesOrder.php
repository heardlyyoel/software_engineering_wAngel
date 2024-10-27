<?php
include 'db_conn.php';

// take daftar produk for dropdown in <select></select>//
$productSql = "SELECT id, name, price FROM product";
$productResult = $conn->query($productSql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // this from form after submit 
    $orderNum = $_POST['orderNum'];
    $customerRef = $_POST['customerRef'];
    $orderDate = $_POST['orderDate'];

    // save order to table salesOrder
    $sqlOrder = "INSERT INTO salesorder (orderNum, customerRef, orderDate) 
                 VALUES ('$orderNum', '$customerRef', '$orderDate')";

    if ($conn->query($sqlOrder) === TRUE) {
        // so this to take id earlier save
        $orderId = $conn->insert_id;

        // sv dtail order
        foreach ($_POST['product'] as $key => $productId) {
            $qty = $_POST['qty'][$key];
            $discount = $_POST['discount'][$key];

            // add orderdtail
            $sqlDetail = "INSERT INTO orderDetail (orderId, productId, qty, discount) 
                          VALUES ('$orderId', '$productId', '$qty', '$discount')";

            if ($conn->query($sqlDetail) !== TRUE) {
                echo "Error: " . $conn->error;
            }
        }

        // sumary order
        $sqlDisplay = "SELECT od.productId, od.qty, od.discount, p.price,
                       (od.qty * p.price * (1 - od.discount / 100)) AS subtotal,
                       p.name AS productName
                       FROM orderDetail od
                       JOIN product p ON od.productId = p.id
                       WHERE od.orderId = '$orderId'";

        $result = $conn->query($sqlDisplay);

        if ($result->num_rows > 0) {
            echo "<h2>Order Summary</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Discount (%)</th>
                        <th>Sub Total</th>
                    </tr>";
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                $subtotal = $row['subtotal']; 
                echo "<tr>
                        <td>" . $row['productName'] . "</td>
                        <td>" . $row['qty'] . "</td>
                        <td>" . number_format($row['price'],2) . "</td>
                        <td>" . $row['discount'] . "</td>
                        <td>" . number_format($subtotal,2) . "</td>
                      </tr>";
                $total += $subtotal;
            }
            echo "<tr>
                    <td colspan='4' style='text-align:right;'><strong>Total:</strong></td>
                    <td>" . number_format($total,2) . "</td>
                  </tr>";
            echo "</table>";
        } else {
            echo "No products found.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Sales Order</title>
</head>
<body>
    <h2>Customer Sales Order</h2>
    <form method="POST" action="">
        Order Number: <input type="text" name="orderNum" required><br>
        Customer Ref: <input type="text" name="customerRef" required><br>
        Order Date: <input type="date" name="orderDate" required><br><br>

        <h3>Products</h3>
        <div id="product">
            <div class="product-row">
                <select name="product[]" required>
                    <option value="">Select Product</option>
                    <?php 
                    // loop all product
                    $productResult->data_seek(0);
                    while ($row = $productResult->fetch_assoc()) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['name']; ?> - <?= $row['price']; ?></option>
                    <?php } ?>
                </select>
                Quantity: <input type="number" name="qty[]" required>
                Discount: <input type="number" name="discount[]" value="0" required>%<br><br>
            </div>
        </div>

        <button type="button" onclick="addProduct()">Add another product</button><br><br>
        <input type="submit" value="Submit Order">
    </form>

    <script>
        function addProduct() {
            // get elemen prodct
            var productRow = document.querySelector(".product-row").cloneNode(true);
            productRow.querySelector("select").selectedIndex = 0;
            productRow.querySelector("input[name='qty[]']").value = '';
            productRow.querySelector("input[name='discount[]']").value = '0';
            document.getElementById("product").appendChild(productRow);
        }
    </script>
</body>
</html>
