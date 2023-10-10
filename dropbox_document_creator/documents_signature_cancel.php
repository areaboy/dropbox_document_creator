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

if($signature_request_id == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Signature Request ID is Empty</div><br>";
exit();
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.hellosign.com/v3/signature_request/cancel/$signature_request_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $dropbox_apikey . ":");  

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   // echo $error_msg = curl_error($ch);
}

if($http_status == 200){
//echo "<div style='background:red;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Canceling of  Incomplete Signature Request Successful</div><br>";
//echo "<script>alert('Canceling of  Incomplete Signature Request Successful');</script>";
echo 1;
exit();
}



curl_close($ch);


}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>