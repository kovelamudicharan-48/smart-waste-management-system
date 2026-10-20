<?php 
$con = mysqli_connect('127.0.0.1:3307', 'root', '', 'wms');
$db = $con;

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>