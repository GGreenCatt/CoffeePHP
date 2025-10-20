<?php
$host="127.0.0.1";
$username="root";
$password="";
$database="coffee";
$conn = mysqli_connect($host,$username,$password,$database);
mysqli_query($conn,"set names'utf8'");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>