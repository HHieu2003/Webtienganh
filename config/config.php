<?php
$conn = mysqli_connect("localhost","root","","quanlykhoahoc") ;

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Thiết lập charset
mysqli_set_charset($conn, "utf8mb4");
mysqli_query($conn, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
?>
