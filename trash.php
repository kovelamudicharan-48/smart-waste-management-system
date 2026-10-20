<?php 
require_once '../controllerUserData.php';
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: ../reset-code.php');
                exit();
            }
        }else{
            header('Location: ../user-otp.php');
            exit();
        }
    }
}else{
    header('Location: ../login-user.php');
    exit();
}

$msg = "";

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    
    $chk = "";  
    if(isset($_POST['wastetype']) && is_array($_POST['wastetype'])){
        foreach($_POST['wastetype'] as $chk1){  
            $chk .= $chk1 . ",";  
        }
    }

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $location = mysqli_real_escape_string($con, $_POST['location']);    
    $locationdescription = mysqli_real_escape_string($con, $_POST['locationdescription']);
    $date = $_POST['date'];
    
    $file = "";
    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
        $file = time() . "_" . basename($_FILES["file"]["name"]);
        $target_dir = "upload/";
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif", "tif", "tiff");
      
        if(in_array($imageFileType, $extensions_arr)){
            move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
        }
    }

    $sql = "INSERT INTO garbageinfo(name, mobile, email, wastetype, location, locationdescription, file, date, status) 
            VALUES('$name', '$mobile', '$email', '$chk', '$location', '$locationdescription', '$file', '$date', '$status')";
        
    if(mysqli_query($con, $sql)){
        $msg = '<div class="alert alert-success"><span class="fa fa-check"> Complain Registered Successfully! </span> <a href="../adminlogin/welcome.php" class="btn btn-sm btn-primary ml-2">View Complaints</a></div>';
    } else {
        $msg = '<div class="alert alert-danger"><span class="fa fa-times"> Failed to Register Complain: ' . mysqli_error($con) . '</span></div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Complain - Waste Management</title>
</head>
<body>
    <div style="padding: 15px;">
        <a href="../index.html" class="btn btn-outline-primary fa fa-home"> Home</a>
        <a href="../adminlogin/welcome.php" class="btn btn-outline-info fa fa-list"> Preview Complain</a>
    </div>

    <form method="post" action="trash.php" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <img src="waste_icon.png" alt="image" style="max-width: 130px; margin-bottom: 15px; border-radius: 50%;">
                    <h2>Register Your Complain</h2>
                    <h4>We would love to hear from you!</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <?php if(!empty($msg)) { echo $msg; } ?>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="name" placeholder="Enter Your Name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mobile">Mobile:</label>
                        <div class="col-sm-10">          
                            <input type="number" class="form-control" id="mobile" placeholder="Enter Your Mobile Number" name="mobile" required>
                        </div>
                    </div>
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"> 
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2">Category:</label>
                        <div class="col-sm-10">          
                            <input type="checkbox" name="wastetype[]" value="organic"> Organic
                            <input type="checkbox" name="wastetype[]" value="inorganic"> Inorganic
                            <input type="checkbox" name="wastetype[]" value="Household"> Household
                            <input type="checkbox" name="wastetype[]" value="mixed" checked> All
                        </div>
                    </div>

                    <!-- Andhra Pradesh Locations Dropdown -->
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="location">Location:</label>
                        <div class="col-sm-10">          
                            <select class="form-control" id="location" name="location" required>
                                <option value="" disabled selected>-- Select Location / District --</option>
                                
                                <optgroup label="Local Towns & Cities">
                                    <option value="Kanchikacherla">Kanchikacherla</option>
                                    <option value="Nandigama">Nandigama</option>
                                    <option value="Vijayawada">Vijayawada</option>
                                    <option value="Jaggayyapeta">Jaggayyapeta</option>
                                    <option value="Ibrahimpatnam">Ibrahimpatnam</option>
                                    <option value="Guntur">Guntur</option>
                                    <option value="Mangalagiri">Mangalagiri</option>
                                    <option value="Tenali">Tenali</option>
                                </optgroup>

                                <optgroup label="Major Municipal Corporations">
                                    <option value="Visakhapatnam">Visakhapatnam</option>
                                    <option value="Tirupati">Tirupati</option>
                                    <option value="Rajahmundry">Rajahmundry</option>
                                    <option value="Kakinada">Kakinada</option>
                                    <option value="Nellore">Nellore</option>
                                    <option value="Kurnool">Kurnool</option>
                                    <option value="Kadapa">Kadapa</option>
                                    <option value="Anantapur">Anantapur</option>
                                    <option value="Eluru">Eluru</option>
                                    <option value="Ongole">Ongole</option>
                                    <option value="Machilipatnam">Machilipatnam</option>
                                </optgroup>

                                <optgroup label="All Andhra Pradesh Districts (26)">
                                    <option value="Alluri Sitharama Raju">Alluri Sitharama Raju</option>
                                    <option value="Anakapalli">Anakapalli</option>
                                    <option value="Ananthapuramu">Ananthapuramu</option>
                                    <option value="Annamayya">Annamayya</option>
                                    <option value="Bapatla">Bapatla</option>
                                    <option value="Chittoor">Chittoor</option>
                                    <option value="Dr. B.R. Ambedkar Konaseema">Dr. B.R. Ambedkar Konaseema</option>
                                    <option value="East Godavari">East Godavari</option>
                                    <option value="Eluru">Eluru</option>
                                    <option value="Guntur">Guntur</option>
                                    <option value="Kakinada">Kakinada</option>
                                    <option value="Krishna">Krishna</option>
                                    <option value="Kurnool">Kurnool</option>
                                    <option value="Nandyal">Nandyal</option>
                                    <option value="NTR District">NTR District</option>
                                    <option value="Palnadu">Palnadu</option>
                                    <option value="Parvathipuram Manyam">Parvathipuram Manyam</option>
                                    <option value="Prakasam">Prakasam</option>
                                    <option value="Srikakulam">Srikakulam</option>
                                    <option value="Sri Potti Sriramulu Nellore">Sri Potti Sriramulu Nellore</option>
                                    <option value="Sri Sathya Sai">Sri Sathya Sai</option>
                                    <option value="Tirupati">Tirupati</option>
                                    <option value="Visakhapatnam">Visakhapatnam</option>
                                    <option value="Vizianagaram">Vizianagaram</option>
                                    <option value="West Godavari">West Godavari</option>
                                    <option value="YSR Kadapa">YSR Kadapa</option>
                                </optgroup>

                                <optgroup label="Other">
                                    <option value="Other Area">Other Area</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="locationdescription">Description:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" id="locationdescription" placeholder="Enter Street / Landmark / Colony details..." name="locationdescription" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="file">Pictures:</label>
                        <div class="col-sm-10">          
                            <input type="file" class="form-control" id="file" name="file" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="status" value="Pending">
                            <input type="hidden" name="date" value="<?php date_default_timezone_set('Asia/Kolkata'); echo date('g:ia, l jS F Y'); ?>">
                            <button type="submit" class="btn btn-success" name="submit">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>