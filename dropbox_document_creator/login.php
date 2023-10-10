

<?php
error_reporting(0); 
session_start();

$email = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);


if ($email == ''){
echo "<div class='alert alert-danger' id='alerts_login'><font color=red>Email is empty</font></div>";
exit();
}


if ($password == ''){
echo "<div class='alert alert-danger' id='alerts_login'><font color=red>password is empty</font></div>";
exit();
}



include('data6rst.php');

// log in if data were okay
$result = $db->prepare('SELECT * FROM users_docs where email = :email and password = :password');

		$result->execute(array(
			':email' => $email,
':password' => $password

    ));

$count = $result->rowCount();

$row = $result->fetch();

if( $count == 1 ) {
//session_start();
session_regenerate_id();

// initialize session if things where ok.
$_SESSION['uid2'] = $row['id'];
$_SESSION['fullname2'] = $row['fullname'];
$_SESSION['email2'] = $row['email'];
$_SESSION['timing2'] = time();
//$_SESSION['status2'] = $row['status'];
$status = $row['status'];

echo "<div class='alert alert-success'>login sucessful <img src='ajax-loader.gif'></div>";
echo "<script>window.location='dashboard.php'</script>";





}
else {
	
echo "<div class='alert alert-danger' id='alerts_login'><font color=red>Either Username or Password is Wrong</font></div>";
}


?>

<?php ob_end_flush(); ?>
