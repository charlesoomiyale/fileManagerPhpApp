<?php 
		
 require_once('connection/connect.php');
 //require_once('include/mail.php');
	
class Controller
{
	public $dbs;
	function __construct()
	 {
		$this->dbs = "TRUE";
	 }

	function SuccessCount() 
	{
		global $db;
        $query = $db->query("SELECT * FROM successcount");
		return $query;
    }
	
	function GetClientLogo() 
	{
		global $db;
        $query = $db->query("SELECT * FROM clientlogo");
		return $query;
    }
	
	function GetService() 
	{
		global $db;
        $query = $db->query("SELECT * FROM service");
		return $query;
    }
	
	function GetBoardsOfDirector() 
	{
		global $db;
        $query = $db->query("SELECT * FROM `boardofdirector`");
		return $query;
    }

	function GetTeam() 
	{
		global $db;
        $query = $db->query("SELECT * FROM `team`");
		return $query;
    }

    function GetJobs() 
	{
		global $db;
        $query = $db->query("SELECT * FROM `jobs` WHERE (DATE(NOW()) between job_start_date and job_end_date) 
        	and status = 1 order by id desc; ");
		return $query;
    }
	
	function Getportfolio() 
	{
		global $db;
        $query = $db->query("SELECT * FROM `product`");
		return $query;
    }

    // Post update...
    function GetAllPostByCategory($postCat, $limitOffset, $limitCount)
    {
    	global $db;
        $query = $db->query("SELECT * FROM `posts` WHERE post_cat_id='".$postCat."' AND status=1 ORDER BY id DESC LIMIT ".$limitOffset.", ".$limitCount.";");
		return $query;
    }

    function GetAllPublishPostCount($postCat)
    {
    	global $db;
        $query = $db->query("SELECT count(*) FROM `posts` WHERE post_cat_id='".$postCat."' AND status=1 ");
		return $query->fetch_array();
    }

    function GetPostDetails($postId){
    	global $db;
        $query = $db->query("SELECT * FROM `posts` WHERE id='".$postId."'; ");
		return $query->fetch_array();
    }

    function GetAllPostSlides($postId)
    {
    	global $db;
        $query = $db->query("SELECT * FROM `postslider` WHERE post_id='".$postId."' ORDER BY id DESC");
		return $query;
    }

    function GetAllPostGalleryImages($postId)
    {
    	global $db;
        $query = $db->query("SELECT * FROM `postgalleryimage` WHERE post_id='".$postId."' ORDER BY id DESC");
		return $query;
    }
}

?>