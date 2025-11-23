<?php
$conn = new mysqli("localhost","root","","crudtybca23");

if($conn->connect_error){
    die("Database Connection Failed: " . $conn->connect_error);
}
?>