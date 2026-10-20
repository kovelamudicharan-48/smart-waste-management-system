<?php
include("connection.php");

// Ensure database connection variable is available
if (!isset($db)) {
    $db = $con;
}

if (isset($_GET['i'])) {
    $id = mysqli_real_escape_string($db, $_GET['i']);
    
    $query = "DELETE FROM garbageinfo WHERE Id = '$id'";
    $data = mysqli_query($db, $query);

    if ($data) {
        header("Location: welcome.php");
        exit();
    } else {
        echo "<script>alert('Failed to delete complaint'); window.location.href='welcome.php';</script>";
        exit();
    }
} else {
    header("Location: welcome.php");
    exit();
}
?>