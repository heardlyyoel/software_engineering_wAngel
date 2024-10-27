<?php
// for confirguration our app ya angle
$host = "localhost";
$user = "root";
$password = "";
$dbname = "order"; 

$conn = new mysqli($host, $user, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
