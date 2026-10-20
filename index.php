<!DOCTYPE html>
<html>
<head> 
    <title>Admin Dashboard - Waste Management</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <style>
        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
        @media(min-width:768px) {
            body {
                margin-top: 50px;
            }
        }

        #wrapper {
            padding-left: 0;    
        }

        #page-wrapper {
            width: 100%;        
            padding: 0;
            background-color: #fff;
        }

        @media(min-width:768px) {
            #wrapper {
                padding-left: 225px;
            }

            #page-wrapper {
                padding: 22px 15px;
            }
        }

        /* Top Navigation */
        .top-nav {
            padding: 0 15px;
        }

        .top-nav>li {
            display: inline-block;
            float: left;
        }

        .top-nav>li>a {
            padding-top: 20px;
            padding-bottom: 20px;
            line-height: 20px;
            color: #fff;
        }

        .top-nav>li>a:hover,
        .top-nav>li>a:focus,
        .top-nav>.open>a,
        .top-nav>.open>a:hover,
        .top-nav>.open>a:focus {
            color: #fff;
            background-color: #1a242f;
        }

        /* Side Navigation */
        @media(min-width:768px) {
            .side-nav {
                position: fixed;
                top: 60px;
                left: 225px;
                width: 225px;
                margin-left: -225px;
                border: none;
                border-radius: 0;
                border-top: 1px rgba(0,0,0,.5) solid;
                overflow-y: auto;
                background-color: #37517e;
                bottom: 0;
                overflow-x: hidden;
                padding-bottom: 40px;
            }

            .side-nav>li>a {
                width: 225px;
                border-bottom: 1px rgba(0,0,0,.3) solid;
            }

            .side-nav li a:hover,
            .side-nav li a:focus {
                outline: none;
                background-color: #1a242f !important;
            }
        }

        .navbar-brand {
            padding: 5px 15px;
        }
        .logo1 {
            border-radius: 50%;
        }
        .table img {
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #ddd;
        }
        .table > tbody > tr > td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style='background-color:#37517e'>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.html">
                <img src="Capture.PNG" alt="LOGO" height='50' width='50' class='logo1'>
            </a>
        </div>
        
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">           
            <li>
                <a href="#"><i class="fa fa-user"></i> Admin User</a>
            </li>
        </ul>

        <!-- Sidebar Menu Items -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="../phpGmailSMTP/trash.php"><i class="fa fa-fw fa-plus"></i> New Complaint</a>
                </li>
                <li>
                    <a href="../logout-user.php"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row" id="main">
                <div class="col-sm-12 col-md-12 well" id="content">
                    <h2>Municipal Officer Complaint Dashboard</h2>
                    <p class="text-muted">Review, verify waste pictures, and update status.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="info">
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Waste Category</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Update Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("connection.php");
                                
                                // Fix variable mismatch
                                if (!isset($db)) {
                                    $db = $con;
                                }

                                // Correct path to upload directory
                                $hostForImage = "http://localhost/waste-management-system/phpGmailSMTP/upload/";
                                
                                $query = "SELECT * FROM garbageinfo ORDER BY Id DESC";
                                $data = mysqli_query($db, $query);

                                if ($data && mysqli_num_rows($data) > 0) {
                                    while ($result = mysqli_fetch_assoc($data)) {
                                        $statusClass = (strtolower($result['status']) == 'completed' || strtolower($result['status']) == 'approved') ? 'label-success' : 'label-warning';
                                        
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($result['Id']) . "</td>";
                                        echo "<td><a href='" . $hostForImage . $result['file'] . "' target='_blank'><img src='" . $hostForImage . $result['file'] . "' height='90' width='90'/></a></td>";
                                        echo "<td>" . htmlspecialchars($result['date']) . "</td>";
                                        echo "<td>" . htmlspecialchars($result['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($result['mobile']) . "</td>";
                                        echo "<td>" . htmlspecialchars($result['email']) . "</td>";
                                        echo "<td><strong>" . htmlspecialchars($result['wastetype']) . "</strong></td>";
                                        echo "<td>" . htmlspecialchars($result['location']) . "</td>";
                                        echo "<td>" . htmlspecialchars($result['locationdescription']) . "</td>";
                                        echo "<td><span class='label " . $statusClass . "'>" . htmlspecialchars($result['status']) . "</span></td>";
                                        echo "<td><a href='admindelete.php?i=" . $result['Id'] . "' class='btn btn-danger btn-xs' onclick=\"return confirm('Are you sure you want to delete this record?');\"><i class='fa fa-trash'></i> Delete</a></td>";
                                        echo "<td><a href='status.php?i=" . $result['Id'] . "&s=" . $result['status'] . "' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i> Update</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12' class='text-center text-muted'>No complaints registered yet.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>