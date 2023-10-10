<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);
error_reporting(0);

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('data6rst.php');
include('settings.php');



if($dropbox_apikey ==''){
echo "<div  style='background:red;color:white;padding:10px;border:none;'>Please Ask Admin to Set Dropbox Document Signing APIKey  at <b>settings.php</b> File</div><br>";
exit();

}

$title= strip_tags($_POST['sign_title']);
$subject= strip_tags($_POST['sign_subject']);
$message= strip_tags($_POST['sign_message']);
$name= strip_tags($_POST['sign_name']);
$email= strip_tags($_POST['sign_email']);
$documents_id = strip_tags($_POST['id']);
$documents_time = strip_tags($_POST['tm']);
$timer=  time();

$doc_name= strip_tags($_POST['doc_name']);


if($email ==''){

echo "<div  style='background:red;color:white;padding:10px;border:none;'>Email to Check Cannot be Empty</div><br>";
exit();
}


$em= filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$em){
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>Email Address is Invalid</div>";
exit();
}


if($title == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents Title is Empty</div><br>";
exit();
}

if($subject == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents Subject is Empty</div><br>";
exit();
}


if($message == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents Message is Empty</div><br>";
exit();
}

// Send Documents for Signing via Dropbox....

$file_name_with_full_path="documents_pdf/$doc_name";
if (function_exists('curl_file_create')) { // php 5.5+
  $cFile = curl_file_create($file_name_with_full_path);
} else { // 
  $cFile = '@' . realpath($file_name_with_full_path);
}

// Generated @ codebeautify.org
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.hellosign.com/v3/signature_request/send');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1); 
$post = array(
 'files[0]' => $cFile,
    'title' => $title,
    'subject' => $subject,
    'message' => $message,
    'signers[0][email_address]' => $email,
    'signers[0][name]' => $name,
    'signers[0][order]' => '0',
    'metadata[custom_id]' => $timer,
    'metadata[custom_text]' => 'NDA #9',
    'signing_options[draw]' => '1',
    'signing_options[type]' => '1',
    'signing_options[upload]' => '1',
    'signing_options[phone]' => '1',
    'signing_options[default_type]' => 'draw',
    'test_mode' => '1'
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $dropbox_apikey . ":");  

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

if($output == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Ensure There is Internet Connection and Try Again</div><br>";
echo "<script>alert('Ensure There is Internet Connection and Try Again');</script>";
exit();
}


$json = json_decode($output, true);
$signature_request_id = $json["signature_request"]["signature_request_id"];
$tit = $json["signature_request"]["title"];


$mx_error = $json["error"]["error_msg"];
if($mx_error != ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Dropbox Documents API Error Message: $mx_error</div><br>";
echo "<script>alert('Dropbox Documents API Error Message: $mx_error');</script>";
exit();
}


if($tit != ''){
echo "<div style='background:green;color:white;padding:10px;border:none;'>&nbsp;&nbsp;&nbsp;&nbsp;Documents Successfully Sent...</div><br>";
echo "<script>alert('Documents Successfully Sent...');</script>";
exit();
}







}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>