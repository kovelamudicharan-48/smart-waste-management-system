<?php
include("connection.php");
if (!isset($db)) {
    $db = $con;
}

$id = isset($_GET['i']) ? $_GET['i'] : (isset($_POST['id']) ? $_POST['id'] : '');
$current_status = isset($_GET['s']) ? $_GET['s'] : '';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $new_status = mysqli_real_escape_string($db, $_POST['status']);

    $update_query = "UPDATE garbageinfo SET status = '$new_status' WHERE Id = '$id'";
    $run = mysqli_query($db, $update_query);

    if ($run) {
        header("location: index.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Update failed: " . mysqli_error($db) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Complaint Status</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .status-card {
            max-width: 420px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header-title {
            background-color: #37517e;
            color: #fff;
            margin: -25px -25px 20px -25px;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="status-card">
    <div class="header-title">
        <h4 style="margin:0;">Update Complaint Status</h4>
    </div>

    <?php echo $msg; ?>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <div class="form-group">
            <label>Complaint ID:</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($id); ?>" disabled>
        </div>

        <div class="form-group">
            <label>Select New Status:</label>
            <select name="status" class="form-control" required>
                <option value="Pending" <?php if(strtolower($current_status) == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="In Progress" <?php if(strtolower($current_status) == 'in progress') echo 'selected'; ?>>In Progress</option>
                <option value="Completed" <?php if(strtolower($current_status) == 'completed') echo 'selected'; ?>>Completed</option>
                <option value="Rejected" <?php if(strtolower($current_status) == 'rejected') echo 'selected'; ?>>Rejected</option>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-primary btn-block" style="background-color: #37517e; border: none; padding: 10px;">Update Status</button>
        <a href="index.php" class="btn btn-default btn-block" style="margin-top: 10px;">Cancel / Back to Dashboard</a>
    </form>
</div>

</body>
</html>