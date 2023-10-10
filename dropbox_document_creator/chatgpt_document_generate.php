
<?php


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

//error_reporting(0);


if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');


if($chatgpt_accesstoken ==''){
echo "<div  style='background:red;color:white;padding:10px;border:none;'>Please Ask Admin to Set Chatgpt Access Token at <b>settings.php</b> File</div><br>";
exit();

}

$docs_prompt= strip_tags($_POST['docs_prompt']);
$docs_qty= strip_tags($_POST['docs_qty']);
$docs_character= strip_tags($_POST['docs_character']);
$category= strip_tags($_POST['category']);
$trans_language= strip_tags($_POST['trans_language']);



$docs_prompt_ask ="Generate $docs_prompt in $trans_language Language";


// Make API Call to ChatGPT AI



$url ="https://api.openai.com/v1/completions";
$data_param ='
{
   "model" : "text-davinci-003",
    "prompt":  "'.$docs_prompt_ask.'",
    "max_tokens": '.$docs_character.',
"n": '.$docs_qty.'
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
echo "<div class='col-sm-12 form-group'>
<div style='background:red;color:white;padding:10px;border:none;'>API Call to Chatgpt AI Failed. Ensure there is an Internet  Connections...</div></div><br>";
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
echo "<div class='col-sm-12 form-group'><div style='background:red;color:white;padding:10px;border:none;'>Chatgpt API Error Message: $mx_error.</div></div><br>";
exit();
}


if($id != ''){

echo "<div class='col-sm-12 form-group'><div style='color:white;background:green;padding:10px;' class='alert alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times; <span style='padding:6px;color:white;background:red;border:none;'>(Delete)</span></a><br>

<b>($docs_qty)</b> Contracts Documents Successfully Generated  in (<b>$trans_language Language</b>) Via Chatgpt AI. See Below</div></div>";

}
else {
echo "<div class='col-sm-12 form-group'><div style='color:white;background:red;padding:10px;'>There is an Issue Generating Contracts Documents Via Chatgpt AI. Please Check Internet Connections</div></div>";
exit();

}   

$countx= 1;

echo "<div class='row'>
<div class='col-sm-1'></div> 
<div class='col-sm-10'>";



foreach($json['choices'] as $row){
$countxx = $countx++;

$val = $row["text"];
$val2 = str_replace(',', ',<br>', $val);
$value = str_replace('.', '<br>', $val2);

echo "<div class='col-sm-12 well alert alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times; <span style='padding:6px;color:white;background:red;border:none;'>(Delete)</span></a><br>
";

echo "<span><h4><b>Document Sample $countxx.)</b></h4> $value</span><br><br>";

echo "</div>";


}

echo "

<script>
$(document).ready(function(){
$('#create_chatgpt_btn').click(function(){
		
var titlex = $('.titlex').val();
var messagex = $('.messagex').val();
var filenamex = $('.filenamex').val();
var categoryx = '$category';
var trans_language ='$trans_language';



if(titlex==''){
alert('Documents Title Cannot be Empty');

}
else if(messagex==''){
alert('Paste  & Edit ChatGPT Generated Documents Text Above');

}

else if(filenamex==''){
alert('Document PDF Filename Cannot be Empty');

}

else{

$('#loader_create').fadeIn(400).html('<br><div style=color:black;background:#ddd;padding:10px;><img src=loader.gif style=font-size:20px> &nbsp;Please Wait!. Creating and Generating New Docuents PDF Files</div>');
var datasend = {titlex:titlex,messagex:messagex,categoryx:categoryx, trans_language:trans_language, filenamex:filenamex};


$.ajax({
			
			type:'POST',
			url:'documents_pdf_generate.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){

                        $('#loader_create').hide();
				//$('#result_create').fadeIn('slow').prepend(msg);
$('#result_create').html(msg);



			
			}
			
		});
		
		}
		
					
	});
});

</script>




<div class='well alert alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times; <span style='padding:6px;color:white;background:red;border:none;'>(Delete)</span></a><br>


<center> <h2>Step 2:</h2></center>

<h3 style='color:#008080'> Create New Documents & Generate Documents in PDF</h3>
<div class='col-sm-12 form-group'>
<label>Enter Document PDF Title/Header</label>  <span style='color:red'>Eg. Legal Contracts Documents in <b>$trans_language</b></span>
<input type='text' name='titlex' id='titlex' class='form-control titlex' placeholder='Enter Documents PDF Title'>
            </div><br><br>


<div class='col-sm-12 form-group'>
<label>Enter Document PDF Filename</label> <span style='color:red'>Ie. Name you want to save PDF Document with. Eg.<b> Contracts-Document 1</b></span>
<input type='text' name='filenamex' id='filenamex' class='form-control filenamex' placeholder='Enter Documents PDF Filename' value='Contracts-Document 1'>
            </div><br>

<br>

<div class='col-sm-12'>
<label>Paste  & Edit ChatGPT Generated Documents Text Above</label>
<span><textarea cols='15' rows='15' name='messagex' id='messagex' class='form-control messagex' ></textarea>
</div><br><br>

<div class='well'>
<div id='loader_create'></div>
<div id='result_create'></div>

<button type='button' id='create_chatgpt_btn' class='cat_cssa'  >(Step:2) Create New Documents & Generate PDF Now</button><br><br>
</div>

</div>


</div>";

echo "
<div class='col-sm-1'></div> 
</div>";




}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>
