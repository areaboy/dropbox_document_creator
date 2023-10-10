
<?php


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

//error_reporting(0);


if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');
include('data6rst.php');


if($chatgpt_accesstoken ==''){
echo "<div  style='background:red;color:white;padding:10px;border:none;'>Please Ask Admin to Set Chatgpt Access Token at <b>settings.php</b> File</div><br>";
exit();

}

$trans_language= strip_tags($_POST['trans_language']);
$documents_id = strip_tags($_POST['id']);
$documents_time = strip_tags($_POST['tm']);

if($documents_id == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents ID is Empty</div><br>";
exit();
}

if($documents_time == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents ID 2 is Empty</div><br>";
exit();
}


$result_verified = $db->prepare('select * from documents where id=:id and timing = :timing');
$result_verified->execute(array(':id' =>$documents_id, ':timing' =>$documents_time));
$row = $result_verified->fetch();
$count = $result_verified->rowCount();


$docs = $row['document_extraction'];
$docs_name = $row['document_name'];
$docs_title = $row['document_title'];


if($count != 1){
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>Extracted Text Documents Not Found</div>";
exit();
}



if($trans_language == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Please Enter Translating Language</div><br>";
exit();
}


// sanitize Extracted Text documents

//$doc1 = str_replace("'", '', $docs);
//$doc2 = str_replace('"', '', $doc1);
//$doc3 = str_replace("’", '', $doc2);
//$message1 = str_replace("_", '', $doc3);
//$message2 = str_replace(":", '', $message1);

//$message = strip_tags(trim(str_replace("\r\n", "", $message2)));

// Remove special characters
//echo $message = preg_replace('/[^A-Za-z0-9]/', '', $message1);

// Remove special characters except space
//echo $message = preg_replace('/[^A-Za-z0-9 ]/', '', $message1);

// Remove special characters except comma fullstop and space
$message = preg_replace('/[^A-Za-z0-9,. ]/', '', $docs);

$content="Translate $message to $trans_language";

// Make API Call to ChatGPT AI


$url ="https://api.openai.com/v1/completions";
$data_param ='
{
   "model" : "text-davinci-003",
    "prompt":  "'.$content.'",
    "max_tokens": 500,
"n": 3
}
';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $chatgpt_accesstoken"));  
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_param);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$output = curl_exec($ch); 

if($output == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>API Call to Chatgpt AI Failed. Ensure there is an Internet  Connections...</div><br>";
exit();
}




$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   // echo $error_msg = curl_error($ch);
}

curl_close($ch);


$json = json_decode($output, true);
$id = $json["id"];

$mx_error = $json["error"]["message"];
if($mx_error != ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Chatgpt API Error Message: $mx_error.</div><br>";
exit();
}


if($id != ''){

//echo "<div style='color:white;background:green;padding:10px;'>Documents Successfully Translated Via Chatgpt AI. See Below</div>";

}
else {
echo "<div style='color:white;background:red;padding:10px;'>There is an Issue Translating Documents Via Chatgpt AI. Please Check Internet Connections</div>";
exit();

}   

$countx= 1;

echo "<div class='row'>
<div class='col-sm-1'></div> 
<div class='col-sm-10 well'>";
echo "<div class='alert alert-info alert-dismissible' style='color:white;background:green;padding:10px;' id='c_alerts'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times; <span style='padding:6px;color:white;background:red;border:none;'>(Delete)</span></a><br>
Documents Successfull Translated Via ChatGPT AI.</div>";


foreach($json['choices'] as $row){
$countxx = $countx++;

$val = $row["text"];
$val2 = str_replace(',', ',<br>', $val);
$value = str_replace('.', '<br>', $val2);


 echo "<div class='alert alert-info alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times; <span style='padding:6px;color:white;background:red;border:none;'>(Delete)</span></a>
   <span><b>Translated Documents Sample $countxx.)</b> $value</span>
  </div>";

//echo "<span><b>Answer $countxx.)</b> $value</span><br><br>";

//echo "<span><b>$countxx.)</b><textarea cols='50' rows='30' name='messagex' id='messagex' class='form-control messagex' >$val</textarea>";

}
echo "</div>
<div class='col-sm-1'></div> 
</div>";




}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>
