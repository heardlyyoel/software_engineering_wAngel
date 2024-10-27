<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    //adding prodct
    $sql = "INSERT INTO Product (name, price) VALUES ('$name', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form method="POST" action="">
        Product Name: <input type="text" name="name" required><br>
        Price: <input type="number" name="price" required><br><br>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
