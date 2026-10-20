<?php
   include("connection.php");
   if (!isset($db)) {
       $db = $con;
   }
   
   session_start();
   $error = "";
   $active = "";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db, $_POST['username']);
      $mypassword = mysqli_real_escape_string($db, $_POST['password']); 
      
      $sql = "SELECT id FROM adminlogin WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db, $sql);
      
      if($result) {
          $count = mysqli_num_rows($result);
          
          if($count == 1) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $_SESSION['username'] = $myusername;
              $_SESSION['login_user'] = $myusername;
              
              // Municipal Officer Dashboard
              header("location: index.php");
              exit();
          } else {
              $error = "Invalid Username or Password !";
          }
      } else {
          $error = "Database query failed!";
      }
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Admin Login - Waste Management</title>
      <link rel="stylesheet" type="text/css" href="login.css">     
   </head>
   
   <body bgcolor="#FFFFFF">
      <div align="center" style="margin-top: 100px;">
         <div style="width:320px; border: solid 1px #333333; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.15);" align="left">
            <div style="background-color:#37517e; color:#FFFFFF; padding:12px; font-size:16px;">
               <b>Municipal Officer Login</b>
            </div>
            
            <div style="padding: 25px;">
               <form action="" method="post">
                  <?php if(!empty($error)): ?>
                     <div style="font-size:12px; color:#cc0000; margin-bottom:15px;">
                        <b><?php echo $error; ?></b>
                     </div>
                  <?php endif; ?>
                  
                  <label for="uname"><b>Username</b></label><br>
                  <input type="text" name="username" class="box" placeholder="Enter Username" required style="width: 100%; padding: 8px; margin: 8px 0 16px 0; border: 1px solid #ccc; border-radius: 4px;"/><br />
                  
                  <label for="psw"><b>Password</b></label><br>
                  <input type="password" name="password" class="box" placeholder="Enter Password" required style="width: 100%; padding: 8px; margin: 8px 0 20px 0; border: 1px solid #ccc; border-radius: 4px;"/><br/>
                  
                  <button type="submit" name="submit" style="width: 100%; background-color: #37517e; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Login</button>
                  
                  <!-- Registration link for new officers -->
                  <div style="text-align: center; margin-top: 18px; font-size: 13px;">
                     New Municipal Officer? <a href="adminsignup.php" style="color: #37517e; font-weight: bold; text-decoration: underline;">Register Here</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>