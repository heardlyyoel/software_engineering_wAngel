<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $sql = "INSERT INTO Product (name, price) VALUES ('$name', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>New product added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="addProduct.css">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST" action="">
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" required><br><br>
            <input type="submit" value="Add Product">
        </form>
        <a href="index.php" class="back-button">Back</a>
    </div>
</body>
</html>
