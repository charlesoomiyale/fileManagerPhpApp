<?php

		// Localhost Test Database
		$DBServer = "localhost"; //host
		$DBName= "filemanager"; //dbname
		$DBUser = "root";//db username
		$DBPass = ""; //db password
		$DBPort = "3307";

		$db = new mysqli($DBServer, $DBUser, $DBPass, $DBName, $DBPort);

		// check connection
		if ($db->connect_error) {
		  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		}

?>

<?php

////ENTER YOUR DATABASE CONNECTION INFO BELOW:
//$hostname="db722347199.db.1and1.com";
//$database="db722347199";
//$username="dbo722347199";
//$password="xpressweb";
//
////DO NOT EDIT BELOW THIS LINE
//$link = mysql_connect($hostname, $username, $password);
//if (!$link) {
//die('Connection failed: ' . mysql_error());
//}
//else{
//     echo "Connection to MySQL server " .$hostname . " successful!
//" . PHP_EOL;
//}
//
//$db_selected = mysql_select_db($database, $link);
//if (!$db_selected) {
//    die ('Can\'t select database: ' . mysql_error());
//}
//else {
//    echo 'Database ' . $database . ' successfully selected!';
//}
//
//mysql_close($link);

?>
