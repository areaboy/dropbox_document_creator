<?php
error_reporting(0);

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('data6rst.php');
include('settings.php');

if($dropbox_apikey ==''){
echo "<div  style='background:red;color:white;padding:10px;border:none;'>Please Ask Admin to Set Dropbox Document Signing APIKey  at <b>settings.php</b> File</div><br>";
exit();

}

$signature_request_id= strip_tags($_POST['id']);
$email_address= strip_tags($_POST['email_address']);


if($signature_request_id == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Signature Request ID is Empty</div><br>";
exit();
}

$post = array(
 'email_address' => $email_address
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.hellosign.com/v3/signature_request/remind/$signature_request_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $dropbox_apikey . ":");  
//curl_setopt($ch, CURLOPT_POST, TRUE);
$output = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   // echo $error_msg = curl_error($ch);
}

curl_close($ch);

if($output == ''){
echo "<span style='color:red; font-size:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;Check Internet Connections..</span>";
echo "<script>alert('Ensure There is Internet Connection and Try Again');</script>";
exit();
}


$json = json_decode($output, true);

$mx_error = $json["error"]["error_msg"];
if($mx_error != ''){
echo "<span style='color:red; font-size:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;API Error Message: $mx_error</span>";
echo "<script>alert('Dropbox Documents API Error Message: $mx_error');</script>";
exit();
}


if($http_status == 200){
echo "<span style='color:green; font-size:10px;'>>&nbsp;&nbsp;&nbsp;&nbsp;Reminder Sent</span>";
echo "<script>alert('Reminder Sent Successful');</script>";

exit();
}




}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>