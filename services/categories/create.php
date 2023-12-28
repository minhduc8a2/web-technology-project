<?php
require dirname(__DIR__, 1) . '\connect_db.php';
$name = "Giày chạy bộ";


$sql = "INSERT INTO categories (name)
VALUES ('$name');";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('New record created successfully')</script>";
} else {
    echo "<script>console.log('Failed to create')</script>";
}

$conn->close();
