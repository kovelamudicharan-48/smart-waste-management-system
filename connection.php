<?php 
$con = mysqli_connect('127.0.0.1:3307', 'root', '', 'wms');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>