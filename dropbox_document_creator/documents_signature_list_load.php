<?php


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

error_reporting(0);


session_start();

$userid =  htmlentities(htmlentities($_SESSION['uid2'], ENT_QUOTES, "UTF-8"));
$fullname =  htmlentities(htmlentities($_SESSION['fullname2'], ENT_QUOTES, "UTF-8"));
$email =  htmlentities(htmlentities($_SESSION['email2'], ENT_QUOTES, "UTF-8"));

?>


<script>
$(document).ready(function(){

$('.cancel_btn').click(function(){
// confirm start
 if(confirm("Are you sure you want to Cancel This Signature Request. ")){
var id = $(this).data('id');

$(".loader-cancel_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;font-size:10px;"><img src="ajax-loader.gif">&nbsp;Wait. Canceling...</div>');
var datasend = {'id': id};
		$.ajax({
			
			type:'POST',
			url:'documents_signature_cancel.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){

if(msg.trim() == 1){

alert('Signature Successfully Canceled');
$(".loader-cancel_"+id).hide();
$(".result-cancel_"+id).html("<div style='color:white;background:green;padding:10px;'>Canceled.</div>");
setTimeout(function(){ $(".result-cancel_"+id).html(''); }, 5000);
$(".rec_"+id).animate({ backgroundColor: "#fbc7c7" }, "fast").animate({ opacity: "hide" }, "slow");

}else{

alert('Signature Canceling Failed');
$(".loader-cancel_"+id).hide();
$(".result-cancel_"+id).html(msg);
setTimeout(function(){ $(".result-cancel_"+id).html(''); }, 5000);

}







}
			
});
}

// confirm ends

                });

            });



// Send Reminder
$(document).ready(function(){

$('.reminder_btn').click(function(){
var id = $(this).data('id');
var email_address = $(this).data('email_address');

$(".loader-reminder_"+id).fadeIn(400).html('<br><div style="color:black;background:white;padding:10px;font-size:10px;"><img src="ajax-loader.gif">&nbsp;Wait. Sending Reminder...</div>');
var datasend = {'id': id, email_address:email_address};
		$.ajax({
			
			type:'POST',
			url:'documents_signature_reminder.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){

$(".loader-reminder_"+id).hide();
$(".result-reminder_"+id).html(msg);
setTimeout(function(){ $(".result-reminder_"+id).html(''); }, 6000);

}
			
});

                });

            });

</script>
<?php

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');
include('data6rst.php');



if($dropbox_apikey ==''){
echo "<div  style='background:red;color:white;padding:10px;border:none;'>Please Ask Admin to Set Dropbox Document Signing APIKey  at <b>settings.php</b> File</div><br>";
exit();

}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.hellosign.com/v3/signature_request/list');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $dropbox_apikey . ":");  

 $output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);



if($output == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Documents API Signature Listing Failed. Ensure There is Internet Connection and Try Again</div><br>";
echo "<script>alert('Documents Signature Listing Failed. Ensure There is Internet Connection and Try Again');</script>";
exit();
}



$json = json_decode($output, true);
$page = $json["list_info"]["page"];
$num_pages = $json["list_info"]["num_pages"];
$num_results = $json["list_info"]["num_results"];
$page_size = $json["list_info"]["page_size"];


$mx_error = $json["error"]["error_msg"];
if($mx_error != ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Dropbox Documents API Error Message: $mx_error</div><br>";
echo "<script>alert('Dropbox Documents API Error Message: $mx_error');</script>";
exit();
}

if($page != ''){
echo "<div style='background:green;color:white;padding:10px;border:none;font-size:18px;'>&nbsp;&nbsp;&nbsp;&nbsp;Signature Request Listed Successfully Via Dropbox API</div>";
echo "<script>alert('Signature Request Listed Successfully Via Dropbox API');</script>";

}




echo '<div class="row"><div class="col-sm-1"></div>
<div class="col-sm-10">
<table border="0" cellspacing="2" cellpadding="2" class="table table-striped_no table-bordered table-hover"> 
      <tr> 
<th> <font face="Arial">Name</font> </th> 
          <th> <font face="Arial">Email</font> </th> 
          <th> <font face="Arial">Title</font> </th> 
<th> <font face="Arial">Subject</font> </th> 
<th> <font face="Arial">Message</font> </th>
<th> <font face="Arial">Status</font> </th>
<th> <font face="Arial">Time Created</font> </th>
<th> <font face="Arial">Action</font> </th> 
</tr>';
foreach($json['signature_requests'] as $row){
$signature_request_id = $row['signature_request_id'];
$id = $signature_request_id;
$title = $row['title'];
$subject = $row['subject'];
$message = $row['message'];
$created_at = $row['created_at'];
$is_complete = $row['is_complete'];
$signer_email_address = $row['signatures'][0]['signer_email_address'];

$signer_name =$row['signatures'][0]['signer_name'];
$status_code = $row['signatures'][0]['status_code'];

//if($is_complete ==1){

if($status_code =='signed'){
$cat = "<div style='color:green; font-size:12px;'>Document Signed.</div>";
$reminder ="";
//$colorx ="red_css";
}else{
$cat = "<div style='color:red; font-size:12px;'>Document Awaiting Signature.</div>";

$reminder ="
   <span style='' class='loader-reminder_$id'></span>
   <span style='' class='result-reminder_$id'></span>
<button style='' class='btn btn-primary reminder_btn btn-xs' data-id='$id' data-email_address='$signer_email_address' title='Send Signature Reminder'>Send  Signature Reminder</button>";
}



 echo "<tr class='rec_$id' > 

<td>

<b>$signer_name</b>
</td>

         
                  
                  <td>$signer_email_address</td>



                  <td>$title</td> 

                  <td>$subject</td> 
 <td>$message</td> 
 <td>$cat $reminder</td>   
 <td><span data-livestamp='$created_at'></span></td>  
                 
 <td>

   <div style='' class='loader-cancel_$id'></div>
   <div style='' class='result-cancel_$id'></div>
<button style='' class='btn btn-danger cancel_btn btn-xs' data-id='$id'  title='Cancel Signature'>Cancel Signature</button>


</td>
              </tr>";





}

echo "</div><div class='col-sm-1'></div></div>";



}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}



?>
