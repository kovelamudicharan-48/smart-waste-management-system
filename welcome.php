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
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Welcome</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
      margin: 0;
      font-family: "Lato", sans-serif;
    }

    .sidebar {
      margin: 0;
      padding: 0;
      width: 150px;
      background-color: #37517e;
      position: fixed;
      height: 100%;
      overflow: auto;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 16px;
      text-decoration: none;
    }
    .sidebar a:hover {
      color: whitesmoke;
      text-decoration: none;
    }
    .logo1{
      border-radius: 50%;
    }

    @media screen and (max-width: 700px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      .sidebar a {float: left;}
      div.content {margin-left: 0;}
    }

    @media screen and (max-width: 400px) {
      .sidebar a {
        text-align: center;
        float: none;
      }
    }
    #ch {
      position: fixed;
      text-align: center;
      overflow: hidden;
    }
    </style>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   </head>
   
   <body> 
   <div class="sidebar">
      <a href="../index.html" class="fa fa-home"><strong> Home - <img src="Capture.PNG" alt="LOGO" height='30' width='30' class='logo1'></strong></a>
   </div><br>
      
   <div class="container" id="ch"> <b><mark> YOUR COMPLAIN HISTORY </mark></b></div>
   <div class="container" style="margin-left: 170px;">     
      <table cellspacing="10" class='table'>
         <br><br>
         <tr>
             <th>Date</th>
             <th>Name</th>
             <th>Mobile</th>
             <th>Email</th>
             <th>Type of Waste</th>
             <th>Location</th>
             <th>Location Description</th>
             <th>Images</th>
             <th>Status</th>
             <th colspan="2" align="center">Operations</th>
         </tr>

   <?php
   include("connection.php");

   $sessionEmail = $_SESSION['email'];
   $hostForImage = "http://localhost/waste-management-system/phpGmailSMTP/upload/";
   $query = "SELECT * FROM garbageinfo WHERE email = '$sessionEmail'";
   $data = mysqli_query($con, $query);
   $total = mysqli_num_rows($data);
     
   if($total != 0) {
      while($result = mysqli_fetch_assoc($data)){
         $filePath = $hostForImage . $result['file'];
         
         echo "<tr class='shadow p-3 mb-5 bg-white rounded'>";
         echo "<td>" . $result['date'] . "</td>";
         echo "<td>" . $result['name'] . "</td>";
         echo "<td>" . $result['mobile'] . "</td>";
         echo "<td>" . $result['email'] . "</td>";
         echo "<td>" . $result['wastetype'] . "</td>";
         echo "<td>" . $result['location'] . "</td>";
         echo "<td>" . $result['locationdescription'] . "</td>";
         
         echo "<td>";
         if(!empty($result['file'])) {
             echo "<a href='" . $filePath . "' target='_blank'>";
             echo "<img src='" . $filePath . "' height='100' width='100' style='object-fit:cover; border-radius:4px; border:1px solid #ddd;' alt='Waste Image'/>";
             echo "</a>";
         } else {
             echo "<span class='text-muted'>No Image</span>";
         }
         echo "</td>";
         
         echo "<td><span class='badge badge-info'>" . $result['status'] . "</span></td>";
         echo "<td><a href='#' class='btn btn-danger' data-toggle='modal' data-target='#exampleModalCenter' onclick='modalLauch(" . $result['Id'] . ")'>Delete</a></td>";
         echo "<td><a href='update.php?i=" . $result['Id'] . "&n=" . $result['name'] . "&mbl=" . $result['mobile'] . "&em=" . $result['email'] . "&wt=" . $result['wastetype'] . "&lo=" . $result['location'] . "&lod=" . $result['locationdescription'] . "&f=" . $result['file'] . "&d=" . $result['date'] . "' class='btn btn-success'>Edit</a></td>";
         echo "</tr>";
      }
   }
   ?>

   <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
       <div class='modal-dialog modal-dialog-centered' role='document'>
           <div class='modal-content'>
               <div class='modal-header'>
                   <h5 class='modal-title' id='exampleModalLongTitle'>Delete</h5>
                   <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                   </button>
               </div>
               <div class='modal-body'>
                   Are you sure you want to delete this complain?
                   <input id="toDeleteId" type="hidden" value="">
               </div>
               <div class='modal-footer'>
                   <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                   <button type='button' class='btn btn-danger' onclick="confirmDelete()">Delete</button>
               </div>
           </div>
       </div>
   </div>
   
   </table>
   </div>

   <script>
   var delId;
   function modalLauch(id){
       delId = id;
       $('#toDeleteId').val(id);
   }
   function confirmDelete(){
       window.location.replace("delete.php?i=" + delId);
   }
   </script>
   </body>
</html>