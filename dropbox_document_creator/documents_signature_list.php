<?php
//error_reporting(0);
session_start();
include ('authenticate.php');
include ('settings.php');

$userid_sess =  htmlentities(htmlentities($_SESSION['uid2'], ENT_QUOTES, "UTF-8"));
$fullname_sess =  htmlentities(htmlentities($_SESSION['fullname2'], ENT_QUOTES, "UTF-8"));
$token_sess =   $userid_sess;
$email_sess =  htmlentities(htmlentities($_SESSION['email2'], ENT_QUOTES, "UTF-8"));



?>
<!DOCTYPE html>
<html lang="en">

<head>
 
<title>Welcome <?php echo htmlentities(htmlentities($fullname, ENT_QUOTES, "UTF-8")); ?> to Dropbox Documents Analyzer System </title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="" />
  <script src="scripts/jquery.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="scripts/bootstrap.min.css">

<link type="text/css" rel="stylesheet" href="scripts/store.css">

<script src="scripts/jquery.dataTables.min.js"></script>
  <script src="scripts/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="scripts/dataTables.bootstrap.min.css" />
<script src="scripts/moment.js"></script>
	<script src="scripts/livestamp.js"></script>

  


</head>
<body>



<div class="text-center">
<nav class="navbar navbar-fixed-top" style='background:#008080'>
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navgator">
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span> 
        <span class="navbar-header-collapse-color icon-bar"></span>                       
      </button>
     
<li class="navbar-brand home_click imagelogo_li_remove" ><img class="img-rounded imagelogo_data" src="logo.png"></li>
    </div>
    <div class="collapse navbar-collapse" id="navgator">

      <ul class="nav navbar-nav navbar-right">


<li class="navgate">

<button style='background-color:#008080;' class="invite_btnx btn btn-warning"><a style="color:white;" href='dashboard.php' 
title='Back to Dashboard'>Back to Dashboard</a></button>

</li>




<li class="navgate">

<button style='background-color:#008080;' class="invite_btnx btn btn-warning"><a style="color:white;" href='logout.php' title='Logout'>Logout</a></button>

</li>
</ul>





    </div>
  </div>


</nav>


    </div><br />
<br /><br />



<div style='width:100vw; height: 100vh;  min-height:600px;'>
 

<div class='row'>
<div class='col-sm-12'>
Welcome <b> <?php echo htmlentities(htmlentities($fullname_sess, ENT_QUOTES, "UTF-8")); ?></b>
</div></div><br>









<style>
.report_cssx{
background:#ddd;
padding:10px;
height:70px;
border:none;
color:black;
border-radius:20%;
font-size:16px;
text-align:center;


}


.report_cssx:hover{
background:orange;
color:black;

}

</style>







<style>



.red_css {
    background:red;
    color: white;
    padding: 6px;
border:none;
border-radius:15%;
text-align:center;
font-size:12px;
}

.green_css {
    background:green;
    color: white;
    padding: 6px;
border:none;
border-radius:15%;
text-align:center;
font-size:12px;
width: 90px;
}

.purple_css {
    background:purple;
    color: white;
    padding: 6px;
border:none;
border-radius:15%;
text-align:center;
font-size:12px;
width: 90px;
}

.fuchsia_css {
    background:fuchsia;
    color: white;
    padding: 6px;
border:none;
border-radius:15%;
text-align:center;
font-size:12px;
width: 90px;
}


.c_css{
background: navy;
color:white;
padding:6px;
cursor:pointer;
border:none;
font-size:12px;
//border-radius:25%;
//font-size:16px;
}

.c_css:hover{
background: black;
color:white;

}

</style>



<div class='row'>

<center><h3>Documents Signature Request List Management System</h3></center>

<script>

// loads

$(document).ready(function(){

var id='Dropbox';
$('#loader_sign').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="ajax-loader.gif">&nbsp;Please Wait, Listing Documents Signatures via Dropbox API...</div>');
var datasend = {id:id};	
		$.ajax({
			
			type:'POST',
			url:'documents_signature_list_load.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_sign').hide();
$('#result_sign').fadeIn('slow').html(msg);

			}
			
		
});					
});

</script>


 <div class="form-group">
			<div id="loader_sign"></div>
                        <div id="result_sign"></div>
                       </div>



</div>











</body>
</html>
