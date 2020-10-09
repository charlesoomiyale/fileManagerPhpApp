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

    $catId = null;
    if(isset($_GET['fs'])){
        $catId = $_GET['fs'];
    }else{
        header("Location: home.php");
        exit();
    }

    $category = $control->GetFileCatergory($catId);

    $catGroupSections = $control->GetFileCatergoryGroups($category['id']);
    $userId = $_SESSION['id'];
    $user = $control->GetUser($userId);
    
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

<body class="fix-header fix-sidebar card-no-border">
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
                    <a class="navbar-brand" href="home.php">
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
                            <a  class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/users/1.jpg" alt="user" class="profile-pic m-r-5" /><span class="adminName"> </span></a>
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
                            echo "style='display: none;'";}?> >
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">File manager</li>
                            <li class="breadcrumb-item active"><?php echo  $category['name'];?></li>
                           
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        <!-- <a href="https://wrappixel.com/templates/monsteradmin/" class="btn pull-right hidden-sm-down btn-success"> Upgrade to Pro</a> -->
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
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">Document Loader</h4>
                                <div class="text-left">
                                    <form>
                                        <div class="form-group">
                                            <label class="col-sm-12">Choose Category</label>
                                            <div class="col-sm-12">
                                                <select name="filesection" id="fileDepartmentGroup" class="form-control form-control-line formInput">
                                                    <option value="">Choose..</option>
                                                    <?php foreach ($catGroupSections as $key => $sections) {   ?>
                                                        
                                                    <option value="<?php echo $sections[0] ?>"><?php echo $sections[2]; ?></option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="displaySub" style="display: none">
                                            <label class="col-sm-12">Choose sub section</label>
                                            <div class="col-sm-12">
                                                <select id="fileSubsection" class="form-control form-control-line formInput">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-sm-6">
                        <div class="card" <?php if (!is_null($user) && $user[12] != 1) {
                            echo "style='display: none;'";} ?> >
                            <div class="card-block">
                                <h4 class="card-title">Upload File</h4>
                                <form id="fileUploadForm">
                                    <div>
                                    
                                        <div class="form-group">
                                            <label class="col-sm-12">Choose Category Section</label>
                                            <div class="col-sm-12">
                                                <input type="hidden" id="fileCategory" value="<?php echo $category['id'];?>">
                                                <select name="filesectionUpload" id="filesectionUpload" class="form-control form-control-line formInput">
                                                    <option value="">Choose..</option>
                                                    <?php foreach ($catGroupSections as $key => $sections) {   ?>
                                                        
                                                    <option value="<?php echo $sections[0] ?>"><?php echo $sections[2]; ?></option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="displaySub1" style="display: none">
                                            <label class="col-sm-12">Choose sub section</label>
                                            <div class="col-sm-12">
                                                <select id="fileSubsection1" class="form-control form-control-line formInput">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <input type="file" name="fileFeatInputFile" id="fileFeatInputFile" multiple><span class="text-success">   Click on 'Browse' button to upload new file</span> <br>
                                        <span class="text-muted text-danger">** Only files in PDF, Microsoft Word & Excel and images (jpg, jpeg, png) format are allowed. **</span>
                                        <span id="error_multiple_feat_file"></span>
                                        <div id="uploadingFeat" style="display: none;" >
                                            Loading files.... <img src="../assets/images/pie.gif">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <input type="submit" class="form-control btn btn-success" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <!-- column -->
                    <div class="col-sm-12" >
                        <div id="uploadingFiles" style="margin: 0 auto; display: none;" >
                            Uploading files.... <img src="../assets/images/pie.gif">
                        </div>
                        <div class="card" id="datatableDashboard" style="display: none;">
                            <div class="card-block">
                                <h4 class="card-title">Upload files</h4>
                                <h6 class="card-subtitle">List of all previously uploaded file.</h6>
                                <div class="table-responsive">
                                    <table id="uploadedFileTable" class="table table-striped display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>File name</th>
                                                <th>Uploaded By</th>
                                                <th>Date</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="fileLoaderDatatable">
                                            
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
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Flot Charts JavaScript -->
    <script src="../assets/plugins/flot/jquery.flot.js"></script>
    <script src="../assets/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-data.js"></script>
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
