

<?php
	
//set session
if(!isset($_SESSION['uid2']) || (trim($_SESSION['uid2']) == '')) {
//$username=strip_tags($_GET['username']);
		header("location: index.php");
		exit();
	}


?>