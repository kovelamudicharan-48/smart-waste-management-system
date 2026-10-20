<?php
include("connection.php");
if (!isset($db)) {
    $db = $con;
}

// URL లో 'id' లేదా 'i' లేదా 'delete' ఏది వచ్చినా తీసుకుంటుంది
$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_GET['i'])) {
    $id = $_GET['i'];
} elseif (isset($_GET['delete'])) {
    $id = $_GET['delete'];
}

if (!empty($id)) {
    $id = mysqli_real_escape_string($db, $id);

    // కాలమ్ పేరు 'id' లేదా 'Id' రెండింటికీ పనికొచ్చేలా డిలీట్ చేస్తుంది
    $query = "DELETE FROM garbageinfo WHERE id = '$id' OR Id = '$id'";
    $data = mysqli_query($db, $query);

    if ($data) {
        header("Location: index.php");
        exit();
    } else {
        echo "Delete query failed: " . mysqli_error($db);
        exit();
    }
} else {
    // ఒకవేళ అసలు ఐడీ రాలేదో లేదో తెలుసుకోవడానికి
    echo "Error: Complaint ID not received in URL. Check the delete link in index.php";
    exit();
}
?>