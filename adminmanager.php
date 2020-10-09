<?php
    session_start();

    include_once("controller/AdminController.php");

    $dbControl = new Controller();

if (isset($_POST) && isset($_POST['login'])) {
    # code...
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ((is_null($username) || empty($username)) ||
         (is_null($password) || empty($password)) ) {
        # code...CfaoAdmin123@
        $response = array('status' => 0, 'message' => 'Username or password should not be empty');
        echo json_encode($response);
        exit();

    }

    $adminDetails = $dbControl->GetAdminUser($username, md5($password));

    if (is_null($adminDetails) || empty($adminDetails) ) {
        $response = array('status' => 0, 'message' => 'Invalid username or password !!! ');
        echo json_encode($response );
    }
    else {
        $_SESSION['id'] =  $adminDetails["id"];
        $_SESSION['name'] =  $adminDetails["firstname"]." ".$adminDetails["lastname"];
        $_SESSION['permissions'] =  $adminDetails["permissions"];


        $adminUser = array('username' => $adminDetails["username"], 'isAdmin' => $adminDetails["isAdmin"],
        'firstname' => $adminDetails["firstname"], 'lastname' => $adminDetails["lastname"],
         'file' => $adminDetails["file"], 'news' => $adminDetails["news"],
         'download' => $adminDetails["download"], 'superAdmin' => $adminDetails["superAdmin"] );
         $_SESSION['user'] = $adminUser;

        $response = array('status' => 1, 'username' => $username, 'user' => $adminUser);
        echo json_encode($response );
    }

}

// Update of week info
if (isset($_POST) && isset($_POST['weekinfo'])) {

    if (empty($_POST['week_body']) || empty($_POST['week_body'])){
        # code...
        $response = array('status' => 0, 'message' => 'Weekly information/quote must be provided');
        echo json_encode($response );
        exit();
    }

    $weekInfo = $_POST['week_body'];

    if (strlen($weekInfo) < 10) {
        # code...
        $response = array('status' => 0, 'message' => 'Lenght of provide details was too short (should be minimum 10 in length). ');
        echo json_encode($response );
        exit();
    }

    $_POST['added_by'] = $_SESSION['name'];

    $weekStatus = $dbControl->addNewWeekInfo($_POST);

    if ($weekStatus) {

        $response = array('status' => 1, 'message' => 'Weekly information/quote added successfully!', 'test' => $weekStatus);
        echo json_encode($response );
    } else{

        $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong', 'test' => $weekStatus);
        echo json_encode($response );
    }
}

if (isset($_POST) && isset($_POST['getsections'])) {

    $cat_id = $_POST['cat_id'];
    $group_id = $_POST['group_id'];

    $sections = $dbControl->GetCatergoryGroupSections($cat_id, $group_id);
    $sectionJson = json_encode($sections);

    $response = array('status' => 1, 'message' => 'Sections fetch successfully!!', 'sections' => $sections );
    echo json_encode($response);
    exit();

}

if (isset($_POST) && isset($_POST['loadfiles'])) {

    $cat_id = $_POST['cat_id'];
    $group_id = $_POST['group_id'];
    $section_id = $_POST['section_id'];

    $files = $dbControl->GetAllGroupSectionFiles($cat_id, $group_id, $section_id);

    if (!is_null($files) && !empty($files)) {
        $response = array('status' => 1, 'message' => 'Files fetched successfully!!', 'sections' => $files );
        echo json_encode($response);
        exit();
    }else{
        $response = array('status' => 0, 'message' => 'No files have been uploads under your selection' );
        echo json_encode($response);
        exit();
    }

}

// Update of month info
if (isset($_POST) && isset($_POST['monthinfo'])) {

    if (empty($_POST['monthinfo_body']) || empty($_POST['monthinfo_body'])){
        # code...
        $response = array('status' => 0, 'message' => 'Monthly information/quote must be provided');
        echo json_encode($response );
        exit();
    }

    $monthInfo = $_POST['monthinfo_body'];

    if (strlen($monthInfo) < 10) {
        # code...
        $response = array('status' => 0, 'message' => 'Lenght of provide details was too short (should be minimum 10 in length). ');
        echo json_encode($response );
        exit();
    }

    $_POST['added_by'] = $_SESSION['name'];

    $monthStatus = $dbControl->addNewMonthInfo($_POST);

    if ($monthStatus) {

        $response = array('status' => 1, 'message' => 'Monthly information/quote added successfully!', 'test' => $monthStatus);
        echo json_encode($response );
    } else{

        $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong', 'test' => $monthStatus);
        echo json_encode($response );
    }
}


// File Upload
if ((isset($_FILES) && isset($_POST['fileUpload'])) && $_FILES['file']['name'] > 0) {
    # code...
    // $dirpath = realpath(dirname(getcwd()."\\"));
    $cat_id = $_POST['cat_id'];
    $group_id = $_POST['group_id'];
    $section_id = $_POST['section_id'];

    $dirpath = realpath(getcwd());

    $category = $dbControl->GetFileCatergory($cat_id);
    $group = $dbControl->GetFileCatergoryGroup($group_id);
    $section =  $dbControl->GetFileCatergoryGroupSection($section_id);

    $folderUrl = $category['path']."/".$group['path']."/".$section['path']."/";

    $upload_loc = $dirpath."/uploads/officialfiles/".$folderUrl;
    $file_temp_loc = "uploads/officialfiles/".$folderUrl;

    if (!is_dir($upload_loc)) {
        mkdir($upload_loc, 0777, true);
    }

    $adminid = $_SESSION['id'];
    $uploaded_by = $_SESSION['name'];

    for ($i=0; $i < count($_FILES['file']['name']); $i++) {
        # code...
        $file_name = $_FILES['file']['name'][$i];
        $tmp_name = $_FILES['file']['tmp_name'][$i];
        $file_array = explode(".", $file_name);
        $file_ext = end($file_array);
        $db_file_name = $file_array[0];
        // $new_file_name = "file_".$adminid."_".$i."cfao".rand().".".strtolower($file_ext);
        $new_file_name = str_replace(" ", "_", $db_file_name)."_"."cfao".rand().".".strtolower($file_ext);
        $location = $upload_loc."".$new_file_name;
        $file_url = $file_temp_loc."".$new_file_name;

        $file_name = $db_file_name.".".$file_ext;

        if (file_already_uploaded($adminid, $file_name, 0)) {
            # code...
            // $file_name = $db_file_name."-".rand().".".$file_ext;
            $response = array('status' => 0, 'message' => 'This file has been previously uploaded successfully by you. Please rename the file or delete the old file in order to proceed !!');
            echo json_encode($response);
            exit();
        }

        if (move_uploaded_file($tmp_name, $location)) {
            # code...
            $dbRecord = array('uploaded_by_id' => $adminid, 'uploaded_by' => $uploaded_by, 'file_name' => $file_name, 'file_updated_name' => $new_file_name, 'file_url' => $file_url, 'cat_id' => $cat_id, 'group_id' => $group_id,'section_id' => $section_id );

            $insertFileRec = $dbControl->addFileUpload($dbRecord);
        }

    }

    $response = array('status' => 1, 'message' => 'File uploaded successfully !!');
    echo json_encode($response );
}

// Update of news event
if (isset($_POST) && isset($_POST['newsandevents'])) {

    if (empty($_POST['subject']) || empty($_POST['subject'])){
        # code...
        $response = array('status' => 0, 'message' => 'Please provide subject/headline of the news and event.');
        echo json_encode($response );
        exit();
    }

    if (empty($_POST['news_body']) || empty($_POST['news_body'])){
        # code...
        $response = array('status' => 0, 'message' => 'Writeup of news and event must be provided');
        echo json_encode($response );
        exit();
    }

    $subject = $_POST['subject'];
    $news_body = $_POST['news_body'];
    $update_news = $_POST['editnews'];

    if ((strlen($news_body) < 10) || (strlen($subject) < 10)) {
        # code...
        $response = array('status' => 0, 'message' => 'Lenght of provide details was too short (should be minimum 10 in length: subject or writeup). ');
        echo json_encode($response );
        exit();
    }

    if (isset($update_news) && !empty($update_news)) {
        # Update news
        $newsId = $update_news;

        $newsStatus = $dbControl->updateNewsAndEvent($newsId, $subject, $news_body);

        if ($newsStatus) {

            $response = array('status' => 1, 'message' => 'News and Event details updated successfully!');
            echo json_encode($response );
        } else{

            $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong');
            echo json_encode($response );
        }

    } else{
        # Add news

        $_POST['added_by'] = $_SESSION['name'];

        $newsStatus = $dbControl->addNewEventInfo($_POST);

        if ($newsStatus) {

            $response = array('status' => 1, 'message' => 'News and Event details added successfully!');
            echo json_encode($response );
        } else{

            $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong');
            echo json_encode($response );
        }
    }
}

// Fetch news details
if (isset($_POST) && isset($_POST['getnews'])) {

    $newsId = $_POST['news_id'];

    $newsDetails = $dbControl->FetchNewsEvents($newsId);

    if (count($newsDetails) > 0) {
        # code...
        $response = array('status' => 1, 'message' => 'Successful.', 'news' => $newsDetails);
        echo json_encode($response );
    } else{
        $response = array('status' => 0, 'message' => 'News and event not found, must have been removed by another admin user. ', 'news' => []);
        echo json_encode($response );

    }
}

// Delete news details
if (isset($_POST) && isset($_POST['deletenews'])) {

    $newsId = $_POST['news_id'];

    $newsDeleted = $dbControl->DeleteNewsEvents($newsId);

    if ($newsDeleted) {
        # code...
        $response = array('status' => 1, 'message' => 'Successful deleted.');
        echo json_encode($response );
    } else{
        $response = array('status' => 0, 'message' => 'News and event not found, must have been removed by another admin user. ');
        echo json_encode($response );

    }
}


// Update news banner
if ((isset($_FILES) && isset($_POST['newsBanner'])) && $_FILES['file']['name'] > 0) {
    # code...
    // $dirpath = realpath(dirname(getcwd()."\\"));
    $dirpath = realpath(getcwd());

    $upload_loc = $dirpath."/uploads/news/banners/";
    $file_temp_loc = "uploads/news/banners/";

    $postId = $_POST['postId'];
    $uploaded_by = $_SESSION['name'];

    # code...
    $file_name = $_FILES['file']['name'][0];
    $tmp_name = $_FILES['file']['tmp_name'][0];
    $file_array = explode(".", $file_name);
    $file_ext = end($file_array);
    $db_file_name = $file_array[0];
    $new_file_name = "banner_".$postId."_"."cfao".rand().".".strtolower($file_ext);
    $location = $upload_loc."".$new_file_name;
    $file_url = $file_temp_loc."".$new_file_name;

    $file_name = $db_file_name.".".$file_ext;


    if (move_uploaded_file($tmp_name, $location)) {
        # code...

        $insertBannerRec = $dbControl->updatePostBannerUrl($postId, $file_url);
        if ($insertBannerRec) {
            # code...
            $response = array('status' => 1, 'message' => 'Banner uploaded successfully !!');
            echo json_encode($response );
            exit();
        } else{
            $response = array('status' => 0, 'message' => 'An error occurred while updating record.');
            echo json_encode($response );
            exit();
        }
    }

    // $response = array('status' => 1, 'message' => 'Banner uploaded successfully !!');
    // echo json_encode($response );
}

//User management
if (isset($_POST) && isset($_POST['getuser'])) {

    $userId = $_POST['user_id'];

    $userDetails = $dbControl->FetchUserProfile($userId);

    if (count($userDetails) > 0) {
        # code...
        $response = array('status' => 1, 'message' => 'Successful.', 'user' => $userDetails);
        echo json_encode($response );
    } else{
        $response = array('status' => 0, 'message' => 'User profile not found, must have been removed by another admin user. ', 'user' => []);
        echo json_encode($response );

    }
}

if (isset($_POST) && isset($_POST['userprofile'])) {

    if (empty($_POST['username']) || empty($_POST['username'])){
        # code...
        $response = array('status' => 0, 'message' => 'Username (email address can be use) must be provided');
        echo json_encode($response );
        exit();
    }

    if (empty($_POST['password']) || empty($_POST['password'])){
        # code...
        $response = array('status' => 0, 'message' => 'Default password must be provided');
        echo json_encode($response );
        exit();
    }

    if (empty($_POST['firstname']) || empty($_POST['firstname'])){
        # code...
        $response = array('status' => 0, 'message' => 'Firstname must be provided');
        echo json_encode($response );
        exit();
    }

    if (empty($_POST['lastname']) || empty($_POST['lastname'])){
        # code...
        $response = array('status' => 0, 'message' => 'Lastname must be provided');
        echo json_encode($response );
        exit();
    }

    $checkUser = $dbControl->checkUserProfile($_POST['username']);
    if (!is_null($checkUser) && (count($checkUser) > 0)){
        $response = array('status' => 0, 'message' => 'User profile with same username already exit!!');
        echo json_encode($response );
        exit();
    }

    $_POST['isAdmin'] = '1';
    $password = $_POST['password'];
    $_POST['password'] = md5($password);

    $permissions = [];

    $perm1 = null;
    $perm2 = null;
    $perm3 = null;
    $perm4 = null;
    $perm5 = null;
    $perm6 = null;

    if (isset($_POST['perm1'])) {
        $perm1 = $_POST['perm1'];
    }

    if (isset($_POST['perm2'])) {
        $perm2 = $_POST['perm2'];
    }
    if (isset($_POST['perm3'])) {
        $perm3 = $_POST['perm3'];
    }
    if (isset($_POST['perm4'])) {
        $perm4 = $_POST['perm4'];
    }
    if (isset($_POST['perm5'])) {
        $perm5 = $_POST['perm5'];
    }
    if (isset($_POST['perm6'])) {
        $perm6 = $_POST['perm6'];
    }

    if (!is_null($perm1) && $perm1 == 'on') {
        array_push($permissions, 1);
    }
    if (!is_null($perm2) && $perm2 == 'on') {
        array_push($permissions, 2);
    }
    if (!is_null($perm3) && $perm3 == 'on') {
        array_push($permissions, 3);
    }
    if (!is_null($perm4) && $perm4 == 'on') {
        array_push($permissions, 4);
    }
    if (!is_null($perm5) && $perm5 == 'on') {
        array_push($permissions, 5);
    }
    if (!is_null($perm6) && $perm6 == 'on') {
        array_push($permissions, 6);
    }

    // if (count($permissions) == 0){
    //     # code...
    //     $response = array('status' => 0, 'message' => 'User must be assigned to at least on department!!');
    //     echo json_encode($response );
    //     exit();
    // }


    $_POST['permissions'] = json_encode($permissions);

    $userStatus = $dbControl->addNewUser($_POST);

    if ($userStatus) {

        $response = array('status' => 1, 'message' => 'User added successfully!');
        echo json_encode($response );
    } else{

        $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong');
        echo json_encode($response );
    }
}

if (isset($_POST) && isset($_POST['userprofileupdate'])) {
    $fieldCount = count($_POST) - 2;
    $userId = $_POST['user_id'];

    $checkUser = $dbControl->FetchUserProfile($userId);

    if (is_null($checkUser) || (count($checkUser) == 0)){
        $response = array('status' => 0, 'message' => 'No user profile found!');
        echo json_encode($response );
        exit();
    }

    if (!is_null($_POST['username']) && !empty($_POST['username'])
        && ($checkUser['username'] != $_POST['username'])  ){

        $checkUser = $dbControl->checkUserProfile($_POST['username']);
        if (!is_null($checkUser) && (count($checkUser) > 0)){
            $response = array('status' => 0, 'message' => 'User profile with same username already exit!!');
            echo json_encode($response );
            exit();
        }
    }

    if (!is_null($_POST['password']) && !empty($_POST['password'])){
        $password = $_POST['password'];
        $_POST['password'] = md5($password);
    }else{
        $_POST['password'] = $checkUser['password'];
    }

    $permissions = [];

    $perm1 = null;
    $perm2 = null;
    $perm3 = null;
    $perm4 = null;
    $perm5 = null;
    $perm6 = null;

    if (isset($_POST['perm1'])) {
        $perm1 = $_POST['perm1'];
    }

    if (isset($_POST['perm2'])) {
        $perm2 = $_POST['perm2'];
    }
    if (isset($_POST['perm3'])) {
        $perm3 = $_POST['perm3'];
    }
    if (isset($_POST['perm4'])) {
        $perm4 = $_POST['perm4'];
    }
    if (isset($_POST['perm5'])) {
        $perm5 = $_POST['perm5'];
    }
    if (isset($_POST['perm6'])) {
        $perm6 = $_POST['perm6'];
    }

    if (!is_null($perm1) && $perm1 == 'on') {
        array_push($permissions, 1);
        --$fieldCount;
    }
    if (!is_null($perm2) && $perm2 == 'on') {
        array_push($permissions, 2);
        --$fieldCount;
    }
    if (!is_null($perm3) && $perm3 == 'on') {
        array_push($permissions, 3);
        --$fieldCount;
    }
    if (!is_null($perm4) && $perm4 == 'on') {
        array_push($permissions, 4);
        --$fieldCount;
    }
    if (!is_null($perm5) && $perm5 == 'on') {
        array_push($permissions, 5);
        --$fieldCount;
    }
    if (!is_null($perm6) && $perm6 == 'on') {
        array_push($permissions, 6);
        --$fieldCount;
    }

    // if (count($permissions) == 0){
    //     # code...
    //     $response = array('status' => 0, 'message' => 'User must be assigned to at least on department!!');
    //     echo json_encode($response );
    //     exit();
    // }

    $_POST['permissions'] = json_encode($permissions);

    $userStatus = $dbControl->updateUser($userId, $_POST, $fieldCount);

    if ($userStatus) {

        $response = array('status' => 1, 'message' => 'User updated successfully!');
        echo json_encode($response );
    } else{

        $response = array('status' => 0, 'message' => 'Unsuccessful: Something went wrong');
        echo json_encode($response );
    }
}


// Delete users details
if (isset($_POST) && isset($_POST['deleteuser'])) {

    $userId = $_POST['user_id'];

    $userDeleted = $dbControl->DeleteUserProfile($userId);

    if ($userDeleted) {
        # code...
        $response = array('status' => 1, 'message' => 'User Profile Successfully deleted.');
        echo json_encode($response );
    } else{
        $response = array('status' => 0, 'message' => 'User not found or must have been removed by another admin user. ');
        echo json_encode($response );

    }
}

if (isset($_POST) && isset($_POST['deletefile'])) {

    $fileId = $_POST['file_id'];
    //var_dump($fileId);
    $dirpath = realpath(getcwd());

    $fileDetailRes = $dbControl->FetchFile($fileId);

    if (is_null($fileDetailRes) || (count($fileDetailRes) == 0)){
        $response = array('status' => 0, 'message' => 'File not found!!!');
        echo json_encode($response );
        exit();
    }

    $file_loc = $fileDetailRes[3];
    $file_UploaderId = $fileDetailRes[7];

    $userId = $_SESSION['id'];
    $isSuperAdmin = $_SESSION['user']['superAdmin'];

    //var_dump($isSuperAdmin);

    if ($isSuperAdmin != 1 && ($userId != $isSuperAdmin)){
        $response = array('status' => 0, 'message' => 'You do not have right permission to remove this file.');
        echo json_encode($response );
        exit();
    }

    $deleteCheck = $dbControl->DeleteFile($fileId);

    if ($deleteCheck == true) {

        unlink($file_loc);

        $response = array('status' => 1, 'message' => 'File removed successfully!');
        echo json_encode($response );

    } else{

        $response = array('status' => 0, 'message' => 'Unsuccessfull: Something went wrong');
        echo json_encode($response );
    }
}















function file_already_exist($postid, $file_name, $type){
    $dbControl = new Controller();
    if ($type == 0) {
        # code...
        return $dbControl->findGalleryImage($postid, $file_name);
    }

    if ($type == 1) {
        # code...
        return $dbControl->findSliderImage($postid, $file_name);
    }

}

function file_already_uploaded($adminId, $file_name, $type){
    $dbControl = new Controller();
    if ($type == 0) {
        # code...
        return $dbControl->findFileGallery($adminId, $file_name);
    }

    if ($type == 1) {
        # code...
        return $dbControl->findNewsFeatImage($postid, $file_name);
    }

}


?>
