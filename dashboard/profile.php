<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
    $perms = $_SESSION['permissions'];
    $permissions = json_decode($perms);
    
    include_once("../controller/AdminController.php");
    include_once("../controller/Parsedown.php");
    $parsedown = new Parsedown();

    $control = new Controller();
    $allUsers = $control->GetAllUsers();
    $userId = $_SESSION['id'];
    $user = $control->GetUser($userId);
    $categories = $control->GetCatergories();

     if (!is_null($user) && $user[0] != 1) {
        header('Location: ./home.php');
        die();
     }

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>CFAO File And Information Manager</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo-icon1.png" alt="homepage" class="dark-logo" />
                            
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                            <!-- dark Logo text -->
                            <img src="../assets/images/logo-text1.png" alt="homepage" class="dark-logo" />
                        </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item hidden-sm-down">
                            <!-- <form class="app-search p-l-20">
                                <input type="text" class="form-control" placeholder="Search for..."> <a class="srh-btn"><i class="ti-search"></i></a>
                            </form> -->
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/users/1.jpg" alt="user" class="profile-pic m-r-5" /><span class="adminName">Admin User </span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a href="home.php" class="waves-effect"><i class="fa fa-clock-o m-r-10" aria-hidden="true"></i>Dashboard</a>
                        </li>
                        <li <?php if (!in_array("1", $permissions)) {
                            echo "style='display: none;'";
                        }?> >
                            <a href="filemanager.php?fs=1" class="waves-effect"><i class="fa fa-snowflake-o m-r-10" aria-hidden="true"></i>Quality Management</a>
                        </li>
                        <li <?php if (!in_array("2", $permissions)) {
                            echo "style='display: none;'";
                        }?>>
                            <a href="filemanager.php?fs=2" class="waves-effect"><i class="fa fa-table m-r-10" aria-hidden="true"></i>Production</a>
                        </li>
                        <li <?php if (!in_array("3", $permissions)) {
                            echo "style='display: none;'";
                        }?>>
                            <a href="filemanager.php?fs=3" class="waves-effect"><i class="fa fa-area-chart m-r-10" aria-hidden="true"></i>Projects</a>
                        </li>
                        <li <?php if (!in_array("4", $permissions)) {
                            echo "style='display: none;'";
                        }?>>
                            <a href="filemanager.php?fs=4" class="waves-effect"><i class="fa fa-superpowers m-r-10" aria-hidden="true"></i>Product Engineering</a>
                        </li>

                        <li <?php if (!in_array("5", $permissions)) {
                            echo "style='display: none;'";
                        }?>>
                            <a href="filemanager.php?fs=5" class="waves-effect"><i class="fa fa-microchip m-r-10" aria-hidden="true"></i>Maintenance</a>
                        </li>
                        <li <?php if (!in_array("6", $permissions)) {
                            echo "style='display: none;'";
                        }?> >
                            <a href="filemanager.php?fs=6" class="waves-effect"><i class="fa fa-telegram m-r-10" aria-hidden="true"></i>Organization</a>
                        </li>
                        <li>
                            <a href="newsandevents.php" class="waves-effect"><i class="fa fa-podcast m-r-10" aria-hidden="true"></i>News & Events</a>
                        </li>
                        <li class="superAdmin" <?php if (!is_null($user) && $user[0] != 1) {
                            echo "style='display: none;'";
                        }?> >
                            <a href="profile.php" class="waves-effect"><i class="fa fa-user m-r-10" aria-hidden="true"></i>Profile</a>
                        </li>
                        
                        <li>
                            <a class="waves-effect logout"><i class="fa fa-info-circle m-r-10" aria-hidden="true"></i>Logout</a>
                        </li>
                    </ul>
                    
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <a name="topForm">
                        <div class="card">
                            <div class="card-block">
                                <?php if (!is_null($user)) { ?>
                                    
                                <center class="m-t-30"> <img src="../assets/images/users/5.jpg" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10"><?php echo $user[3] . " ". $user[4] ?></h4>
                                    <!-- <h6 class="card-subtitle">Accoubts Manager Amix corp</h6> -->
                                    <!-- <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                    </div> -->
                                </center>
                                <?php }   ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            
                            <div id="addNewUserForm" class="card-block">
                                <form class="form-horizontal form-material" action="./../adminmanager.php" id="userprofile">
                                    <div class="form-group">
                                        <input type="hidden" name="userprofile" >
                                        <label class="col-md-12">User Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="username" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">First Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="firstname" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="lastname" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email"  class="form-control form-control-line formInput" name="email" id="example-email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="Default Password" name="password" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" name="tel" placeholder="123 456 7890" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Description/Department</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="detail" class="form-control form-control-line formInput"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Permissions</label>
                                        <div class="col-md-12">
                                            <?php foreach ($categories as $key => $cat) { ?>
                                            <div class="form-check">
                                                <label class="form-check-inline"><input type="checkbox" name="perm<?php echo $cat[0]; ?>" > <?php echo $cat[1]; ?></label>
                                            </div>
                                            
                                            <?php  } ?>
                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can Upload files</label>
                                        <div class="col-sm-12">
                                            <select name="file" class="form-control form-control-line formInput">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can download files</label>
                                        <div class="col-sm-12">
                                            <select name="download" class="form-control form-control-line formInput">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can Create/Manage News</label>
                                        <div class="col-sm-12">
                                            <select name="news" class="form-control form-control-line">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success" id="createUserSubmit">Create user profile</button>
                                            <div id="loading" style="display: none;" >
                                                Processing.... <img src="../assets/images/pie.gif">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="editNewUserForm" style="display: none;" class="card-block">
                                <form class="form-horizontal form-material" action="./../adminmanager.php" id="userprofileupdate">
                                    <div class="form-group">
                                        <input type="hidden" name="userprofileupdate" >
                                        <input type="hidden" name="user_id" id="setUserId">
                                        <label class="col-md-12">User Name</label>
                                        <div class="col-md-12">
                                            <input type="text" id="editUsername" name="username" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">First Name</label>
                                        <div class="col-md-12">
                                            <input type="text" id="editFirstname" name="firstname" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" id="editLastname" name="lastname" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" id="editEmail"  class="form-control form-control-line formInput" name="email" id="example-email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="editPassword" placeholder="Default Password" name="password" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" name="tel" id="editTel" placeholder="123 456 7890" class="form-control form-control-line formInput">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Description/Department</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="detail" id="editDetail" class="form-control form-control-line formInput"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Permissions</label>
                                        <div class="col-md-12">
                                            <?php foreach ($categories as $key => $cat) { ?>
                                            <div class="form-check">
                                                <label class="form-check-inline"><input type="checkbox" id="perm_<?php echo $cat[0]; ?>" name="perm<?php echo $cat[0]; ?>" > <?php echo $cat[1]; ?></label>
                                            </div>
                                            
                                            <?php  } ?>
                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can Upload files</label>
                                        <div class="col-sm-12">
                                            <select name="file" id="editFileUpload" class="form-control form-control-line formInput">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can download files</label>
                                        <div class="col-sm-12">
                                            <select name="download" id="editFileDownload" class="form-control form-control-line formInput">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Can Create/Manage News</label>
                                        <div class="col-sm-12">
                                            <select name="news" id="editCanCreateNews" class="form-control form-control-line">
                                                <option value="0">Disapproved</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div id="loading" style="display: none;" >
                                                Processing.... <img src="../assets/images/pie.gif">
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="updateUserSubmit">Update user profile</button>
                                            <button type="button" class="btn btn-danger float-right pull-right" id="cancleUserUpdate">Cancel</button>
                                            
                                        </div>
                                    </div>
                                    <div>
                                        <a href="#topForm" id="gotoToform">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->

                <!-- Row -->
                <div class="row superAdmin">
                    <!-- Column -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Admin users</h4>
                                <h6 class="card-subtitle">List of all profiled users.</h6>
                                <div class="table-responsive">
                                    <table id="uploadedFileTable" class="table table-striped display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Email</th>
                                                <th>Manage</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!is_null($allUsers)){
                                                $usersCount = count($allUsers);

                                                for ($i=0; $i < $usersCount; $i++) { ?>

                                                <tr>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><?php echo $allUsers[$i][1]; ?></td>
                                                    <td><?php echo $allUsers[$i][3]; ?></td>
                                                    <td><?php echo $allUsers[$i][4]; ?></td>
                                                    <td><?php echo $allUsers[$i][5]; ?></td>
                                                    <td>
                                                        <a class="isAdmin" id="viewUserDetails_<?php echo $allUsers[$i][0]; ?>" ><span  style="color: green;"><i class="fa fa-address-book"></i></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="superAdmin editUserBtn" id="editUser_<?php echo $allUsers[$i][0]; ?>" ><span  style="color: green;"><i class="fa fa-edit"></i></span></a>
                                                        <div class="editingUser" style="display: none;" >
                                                            .... <img src="../images/pie.gif" style="height: 14px; width: 14px;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="superAdmin deleteUserBtn" id="deleteUser_<?php echo $allUsers[$i][0]; ?>" ><span  style="color: red;"><i class="fa fa-trash"></i></span></a>
                                                        <div class="deletingUser" id="deletingUser_<?php echo $allUsers[$i][0]; ?>" style="display: none;" >
                                                            .. <img src="../images/pie.gif" style="height: 10px; width: 10px;">
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } }?>
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                © <script>document.write(new Date().getFullYear());</script> BrainBit Solution
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/bootstrap/js/tether.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="../assets/datatable/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../assets/datatable/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>
    <script src="../assets/js/adminscript.js"></script>

</body>

</html>
