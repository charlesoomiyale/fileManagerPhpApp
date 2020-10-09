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
    $allNewsEvents = $control->GetAllNewsEvents();

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
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/users/1.jpg" alt="user" class="profile-pic m-r-5" /><span class="adminName">Admin user </span></a>
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
                            <li class="breadcrumb-item active">News & Events</li>
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
                <div class="row isAdmin">
                    <!-- Column -->
                    <div class="col-sm-6">
                        <div class="card" <?php if (!is_null($user) && $user[13] != 1) {
                            echo "style='display: none;'";} ?> >
                            <div class="card-block">
                                <h4 class="card-title">News & Events</h4>
                                <div class="text-left">
                                    <p>Click on the button add new news and event post</p>
                                </div>
                                <div class="text-right">
                                    <span class="btn btn-lg btn-primary" id="createNews" data-toggle="modal" data-target="#newNewsModal" 
                                    data-backdrop="static" data-keyboard="false">News & Event</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-sm-6">
                        
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <!-- column -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">News & Events</h4>
                            </div>
                        </div>
                    </div>
                    <!-- column  -->
                    <?php 
                        if(!is_null($allNewsEvents)){
                            $newsCount = count($allNewsEvents);

                            for ($i=0; $i < $newsCount; $i++) { ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <img class="card-img-top img-responsive" src="../<?php echo $allNewsEvents[$i][4]; ?>" alt="Card">
                            <div class="card-block">
                                <ul class="list-inline font-14">
                                    <li class="p-l-0"><?php echo date('j F, Y',strtotime($allNewsEvents[$i][5])); ?></li>
                                    <!-- <li><a href="javascript:void(0)" class="link">3 Comment</a></li> -->
                                    <li <?php if (!is_null($user) && $user[13] != 1) {
                                        echo "style='display: none;'";} ?> >
                                        <span class="editNewsBanner btn btn-success" id="<?php echo 'newsBannerEdit_'.$allNewsEvents[$i][0]; ?>" data-toggle="modal" data-target="#newsBannerFileModal" data-backdrop="static" data-keyboard="false" >Change banner</span>
                                        <span class="editNews btn btn-primary" id="<?php echo 'newsEdit_'.$allNewsEvents[$i][0]; ?>" data-toggle="modal" data-target="#newNewsModal" data-backdrop="static" data-keyboard="false" ><i class="fa fa-edit"></i></span>
                                        <span class="deleteNews btn btn-danger" id="<?php echo 'newsEdit_'.$allNewsEvents[$i][0]; ?>" ><i class="fa fa-trash"></i></span>
                                    </li>
                                </ul>
                                <h3 class="font-normal"><?php echo $allNewsEvents[$i][1]; ?> <span class="btn btn-sm btn-primary pull-right readNews" id="readNews_<?php echo $allNewsEvents[$i][0]; ?>" data-toggle="modal" data-target="#readNewsModal" >Read</span></h3>
                                <div class="pull-right" id="deletingNews_<?php echo $allNewsEvents[$i][0]; ?>" style="display: none;" >
                                    Deleting.... <img src="../images/pie.gif" style="height: 14px; width: 14px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }?>
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


            <!-- News info Modal -->
            <div class="modal fade" id="newNewsModal" tabindex="-1" role="dialog" aria-labelledby="newNewsModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="newNewsModalLabel"><span id="newModalTitle">Add</span> News & Events</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                            
                            <div class="col-lg-12 col-md-12">
                                <form name="newsandevents" id="newsandeventsForm" action="./../adminmanager.php">
                                    <div class="form-group">
                                        <input type="hidden" name="newsandevents">
                                        <label for="subject">Subject</label>
                                        <input type="hidden" name="editnews" id="editnewspost">
                                        <input type="text" class="form-control formInput" name="subject" id="subject" required="true" placeholder="Topic/Subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="news_body">Writeup</label>
                                        <textarea rows="10" id="news_body" class="form-control formInput" name="news_body" placeholder="News writeup" required="true"></textarea>
                                    </div>
                                    <div class="form-group">
                                       <button id="newsandeventSubmit" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                    <img src="../assets/images/pie.gif" id="loading" style="display: none;" class="pull-right">
                                
                                </form>
                            </div>
                            
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="closeModal btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
            </div>

            <!-- News read Modal -->
            <div class="modal fade" id="readNewsModal" tabindex="-1" role="dialog" aria-labelledby="readNewsModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="readNewsModalLabel"><span id="readNewsModalSubject">Add</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                            
                            <div class="col-lg-12 col-md-12">
                                <img id="readNewsBannerImg" src="../" class="img img-responsive" style="min-width: 100%; margin-bottom: 10px;">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div id="readNewsModalContent" style="font-size: 17px;">
                                    
                                </div>
                            </div>
                            
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="closeModal btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
            </div>

            <!-- Banner Modal -->
            <div class="modal fade" id="newsBannerFileModal" tabindex="-1" role="dialog" aria-labelledby="newsBannerFileLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="newsBannerFileLabel">Event and News Banner Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                            
                            <div class="col-lg-8 col-md-8">
                                <input type="hidden" id="postBannerId">
                                <input type="file" name="newsBannerInputFile" id="newsBannerInputFile">
                                    <span class="text-muted text-danger">** Only files in .jpg, jpeg, and .png  format are allowed. **</span>
                                    <div id="uploadingBannerImage" style="display: none;" >
                                        Uploading banner.... <img src="../assets/images/pie.gif">
                                    </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <span class="btn btn-warning" id="changeNewsBanner">Upload banner</span>
                            </div>
                            
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="closeModal btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
            </div>

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
