<?php

	require_once('connection/connect.php');

	class Controller
	{
		public $dbs;
		function __construct()
		 {
			$this->dbs = "TRUE";
		 }

		function GetAdminUser($username, $password)
		{
			global $db;
	        $query = $db->query("SELECT * FROM `users` where username='".$username."' AND password='".$password."'");
			return $query->fetch_array();
	    }

	    function GetWeekInfo()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `weeklyinfo` ORDER BY id DESC LIMIT 1");
			return $query->fetch_row();
	    }

	    function GetMonthInfo()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `monthlyinfo` ORDER BY id DESC LIMIT 1");
			return $query->fetch_row();
	    }

	    function GetCatergories(){
	    	global $db;
	        $query = $db->query("SELECT * FROM `filecategory` ");
			return $query->fetch_all();
	    }

	    function GetFileCatergory($catId){
	    	global $db;
	        $query = $db->query("SELECT * FROM `filecategory` where id='".$catId."'; ");
			return $query->fetch_array();
	    }

	    function GetFileCatergoryGroup($groupId){
	    	global $db;
	        $query = $db->query("SELECT * FROM `groupcategory` where id='".$groupId."'; ");
			return $query->fetch_array();
	    }

	    function GetFileCatergoryGroupSection($sectionId){
	    	global $db;
	        $query = $db->query("SELECT * FROM `filesections` where id='".$sectionId."'; ");
			return $query->fetch_array();
	    }

	    function GetFileCatergoryGroups($catId){
	    	global $db;
	        $query = $db->query("SELECT * FROM `groupcategory` where cat_id=".$catId."; ");
			return $query->fetch_all();
	    }

	    function GetCatergoryGroupSections($catId, $groupId){
	    	global $db;
	        $query = $db->query("SELECT * FROM `filesections` where cat_id=".$catId." AND group_id='".$groupId."'");
			return $query->fetch_all();
	    }

	    function addNewWeekInfo($postVal)
	    {
	    	$sql = "INSERT INTO `weeklyinfo` ".
               "(content, added_by) "."VALUES ".
               "('".$postVal['week_body']."','".$postVal['added_by']."')";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function addNewMonthInfo($postVal)
	    {
	    	$sql = "INSERT INTO `monthlyinfo` ".
               "(content, added_by) "."VALUES ".
               "('".$postVal['monthinfo_body']."','".$postVal['added_by']."')";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }


	    function GetAllFiles()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `filesgallery` ORDER BY id DESC LIMIT 20");
			return $query->fetch_all();
	    }

	    function GetAllGroupSectionFiles($catId, $groupId, $sectionId)
		{
			global $db;
			$query = $db->query("SELECT * FROM `filesgallery` where cat_id=".$catId." AND group_id=".$groupId." AND section_id=".$sectionId." ");
			return $query->fetch_all();
	    }

	    function addFileUpload($fileVal)
	    {
	    	$sql = "INSERT INTO `filesgallery` ".
               "(file_name, file_updated_name, file_url, cat_id, group_id, section_id, uploaded_by, uploaded_by_id) "."VALUES ".
               "('".$fileVal['file_name']."','".$fileVal['file_updated_name']."','".$fileVal['file_url']."','".$fileVal['cat_id']."','".$fileVal['group_id']."','".$fileVal['section_id']."','".$fileVal['uploaded_by']."','".$fileVal['uploaded_by_id']."')";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }
		function findFileGallery($adminId, $fileName)
	    {
	    	global $db;
	        $query = $db->query("SELECT * FROM `filesgallery` WHERE uploaded_by_id='".$adminId."' AND file_name='".$fileName."'");
	        $num_of_rows = 0;
					if (!is_null($query->fetch_row())) {
							$num_of_rows = count($query->fetch_row());
					}
	        if ($num_of_rows > 0) {
	        	return true;
	        }
	        else{
	        	return false;
	        }

	    }

	    function GetAllUsers()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `users` ORDER BY id");
			return $query->fetch_all();
	    }

	    function GetUser($userId)
		{
			global $db;
	        $query = $db->query("SELECT * FROM `users` WHERE id ='".$userId."'; ");
			return $query->fetch_array();
	    }

	    function addNewEventInfo($postVal)
	    {
	    	$sql = "INSERT INTO `newsandevents` ".
               "(post_topic, post_body, added_by) "."VALUES ".
               "('".$postVal['subject']."','".$postVal['news_body']."','".$postVal['added_by']."')";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function GetAllNewsEvents()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `newsandevents` ORDER BY id DESC LIMIT 6");
			return $query->fetch_all();
	    }

	    function GetLimitNewsEvents()
		{
			global $db;
	        $query = $db->query("SELECT * FROM `newsandevents` ORDER BY id DESC LIMIT 3");
			return $query->fetch_all();
	    }

	    function FetchNewsEvents($newId)
		{
			global $db;
	        $query = $db->query("SELECT * FROM `newsandevents` WHERE id ='".$newId."'; ");
			return $query->fetch_array();
	    }

	    function updateNewsAndEvent($newsId, $subject, $post_body)
	    {
	    	$sql = "UPDATE `newsandevents` SET post_topic='".$subject."', post_body='".$post_body."' WHERE id='".$newsId."'";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function updatePostBannerUrl($newsId, $postUrl)
	    {
	    	$sql = "UPDATE `newsandevents` SET post_url='".$postUrl."' WHERE id='".$newsId."'";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function DeleteNewsEvents($newsId)
	    {
	    	$sql = "DELETE FROM `newsandevents` WHERE id='".$newsId."' LIMIT 1";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    //User management
	    function FetchUserProfile($userId)
			{
					global $db;
	        $query = $db->query("SELECT * FROM `users` WHERE id ='".$userId."'; ");
					return $query->fetch_array();
	    }

	    function checkUserProfile($userName)
			{
					global $db;
	        $query = $db->query("SELECT * FROM `users` WHERE username ='".$userName."'; ");
					return $query->fetch_array();
	    }

	    function addNewUser($userVal)
	    {

	    	$sql = "INSERT INTO `users` ".
               "(username, password, firstname, lastname, email, permissions, tel, detail, isAdmin, download, file, news) "."VALUES ".
               "('".$userVal['username']."','".$userVal['password']."','".$userVal['firstname']."','".$userVal['lastname']."','".$userVal['email']."','".$userVal['permissions']."','".$userVal['tel']."','".$userVal['detail']
               ."','".$userVal['isAdmin']."','".$userVal['download']."','".$userVal['file']."','".$userVal['news']."')";

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function updateUser($userId, $userVal, $count)
	    {
	    	$sql = "UPDATE `users` SET ";

            if (isset($userVal['username'])) {
           	  $sql .= "username="."'".$userVal['username']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['password'])) {
           	  $sql .= "password="."'".$userVal['password']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['firstname'])) {
           	  $sql .= "firstname="."'".$userVal['firstname']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['lastname'])) {
           	  $sql .= "lastname="."'".$userVal['lastname']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['email'])) {
           	  $sql .= "email="."'".$userVal['email']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['permissions'])) {
           	  $sql .= "permissions="."'".$userVal['permissions']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['tel'])) {
           	  $sql .= "tel="."'".$userVal['tel']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['detail'])) {
           	  $sql .= "detail="."'".$userVal['detail']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['isAdmin'])) {
           	  $sql .= "isAdmin="."'".$userVal['isAdmin']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['download'])) {
           	  $sql .= "download="."'".$userVal['download']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['file'])) {
           	  $sql .= "file="."'".$userVal['file']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            if (isset($userVal['news'])) {
           	  $sql .= "news="."'".$userVal['news']."'";
           	  if ($count > 0) {
           	  	$sql .=",";
           	  	--$count;
           	  }
            }

            $sql .= " WHERE id='".$userId."'";
            //var_dump($sql);

	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function DeleteUserProfile($userId)
	    {
	    	$sql = "DELETE FROM `users` WHERE id='".$userId."' LIMIT 1";
	    	global $db;
	        $query = $db->query($sql);
			return $query;
	    }

	    function FetchFile($fileId)
	    {
	    		global $db;
					$query = $db->query("SELECT * FROM `filesgallery` WHERE id='".$fileId."'; ");
					return $query->fetch_array();
	    }

	    function DeleteFile($fileId)
	    {
	    		$sql = "DELETE FROM `filesgallery` WHERE id='".$fileId."' LIMIT 1";
	    		global $db;
	        $query = $db->query($sql);
					return $query;
	    }














	}
?>
