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
 
<title>Welcome <?php echo htmlentities(htmlentities($fullname, ENT_QUOTES, "UTF-8")); ?> to Dropbox Documents AI Creator </title>

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
<nav class="navbar navbar-fixed-top" style="background:#008080">
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
<button style='background-color:#008080;' data-toggle="modal" data-target="#myModal_document" class="invite_btn btn btn-warning" title=' Create Documents Via ChatGPT'>
Create Documents Via ChatGPT</button>
</li>

<li class="navgate">

<button style='background-color:#008080;' class="invite_btnx btn btn-warning"><a style="color:white;" href='documents_signature_list.php' title='List Signatures'>List & Manage Signatures</a></button>

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
 



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3>Welcome <b><?php echo htmlentities(htmlentities($fullname_sess, ENT_QUOTES, "UTF-8")); ?></b></h3>










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



<script>

// clear Modal div content on modal closef closed
$(document).ready(function(){


$("#myModal_medication").on("hidden.bs.modal", function(){
    //$(".modal-body").html("");
 $('.mydata_empty3').empty(); 
//$('#q').val(''); 
});

});

</script>




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





&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search Documents and Files by <b>Title, Category and Documents Filename, Documents Language (Eg. French, English etc)...</b><br><br>


<div class="container">
<div class="row">
<div class="col-sm-12 table-responsive">
<div class="alert_server_response"></div>
<div class="loader_x"></div>
<table id="bc" class="table table-bordered table-striped">
<thead><tr>
<th>Document Title</th>
<th>Document Name</th>
<th>Document Language</th>
<th>Category</th>
<th>Created Time</th>
<th>Send Documents for Signing</th>
</tr></thead>
</table>
</div>
</div>
</div>




<span class="alert_server_response"></span>
<span class="loader_x"></span>

<script>
$(document).ready(function(){

var get_content = 'get_data';
var backup_type = 'g';
if(get_content=="" && backup_type==""){
alert('There is an Issue with Content Database Retrieval');
}
else{
$('.loader_x').fadeIn(400).html('<br><div style="background:#ccc;color:black; width:100%;height:30%;text-align:center"><img src="ajax-loader.gif">&nbsp;Please Wait, Your Data is being Loaded</div>');
		
 var bck = $('#bc').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"documents_load.php",
   type:"POST",
   data:{get_content:get_content, backup_type:backup_type}
  },
  "columnDefs":[
   {
    "orderable":false,
   },
  ],
  "pageLength": 10
 });

if(bck !=''){
$('.loader_x').hide();
}

}

 
});

</script>


</div>









<script>


$(document).ready(function(){
$('#generate_chatgpt_btn').click(function(){
		
var docs_prompt = $('.docs_prompt').val();
var docs_qty = $(".docs_qty:checked").val();
var docs_character = $(".docs_character:checked").val();
var trans_language =$('.trans_language').val();
var category =  $(".category:checked").val();
    


 if(category==undefined){
alert('Please Select Documents Category');
//return false;
}

else if(docs_prompt==""){
alert('Document Command Prompt Cannot be Empty.');

}

else if(docs_qty==""){
alert('Quantity of Document Sample to be Generated Cannot be Empty.');
}



else if(docs_character==""){
alert('Total Character of Document Text to be Generated Cannot be empty.');

}


else if(trans_language==""){
alert('Documents Translating Language Cannot be empty.');

}

else{

$('#loader_chatgpt').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="ajax-loader.gif">&nbsp;Please Wait, Generating Contracts Document Sample via ChatGPT API...</div>');
var datasend = {docs_prompt:docs_prompt,docs_qty:docs_qty, docs_character:docs_character, category:category,trans_language:trans_language};	
		$.ajax({
			
			type:'POST',
			url:'chatgpt_document_generate.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_chatgpt').hide();
				//$('#result_chatgpt').fadeIn('slow').prepend(msg);

$('#result_chatgpt').fadeIn('slow').html(msg);

//strip all html elemnts using jquery
var html_stripped = jQuery(msg).text();
//alert(html_stripped);

//check occurrence of word (Successful) from backend output already html stripped.
var Frombackend = html_stripped;
var bcount = (Frombackend.match(/Successful/g) || []).length;
//alert(bcount);

if(bcount > 0){
//$('.docs_prompt').val('');
}






			}
			
		});
		
		}
		
	})
					
});

</script>





<style>
.time_css{
background:#ccc;padding:6px;border-radius:20%;
}

.time_css:hover{
background:orange;color:black;
}


.ai_css{
background:fuchsia;
color:white;
padding:10px;
cursor:pointer;
border:none;
border-radius:20%;
font-size:14px;
height:40px;
}

.ai_css:hover{
background: orange;
color:black;

}




.cat_cssa{
background: #ec5574;
color:white;
padding:10px;
cursor:pointer;
border:none;
border-radius:25%;
font-size:12px;
}

.cat_cssa:hover{
background: black;
color:white;

}

.cssx{
background:fuchsia;color:white;padding:6px;border:none;border-radius:25%;
}


.cssx:hover{
background: black;
color:white;

}

</style>



<!--Document  Modal start -->



<div id="myModal_document" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"  style='background:#008080;color:white;padding:10px;'>
        <h4 class="modal-title">Contracts Documents Creator Via ChatGPT AI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">



Easily create <b>Contracts, Business</b> Signing Documents etc. Via <b>ChatGPT AI</b> in various <b>Speaking Languages</b> of Choice<br><br>


<center> <h2>Step 1:</h2></center>

        <div class="well">
    		<label>Documents Category</label><br>

<div class='col-sm-6 time_css'>
<input type="radio"  value="Farmers Documents" id="category" name="category"  class="category"/>Farmers Documents <br>
</div>


<div class='col-sm-6 time_css'>
<input type="radio"  value="Legal Documents" id="category" name="category" class="category"/>Legal Documents <br>
</div>




<div class='col-sm-6 time_css'>
<input type="radio" value="Contract Documents" id="category" name="category" class="category"/>Contract Documents <br>
</div>


<div class='col-sm-6 time_css'>
<input type="radio" value="Business Documents" id="category" name="category" class="category"/>Business Documents <br>
</div>

</div>

<br>
<br>



<p>

<div class="col-sm-12 form-group" style='background:#f1f1f1; padding:16px;color:black'>
<label>Enter Document Command</label> <span style='color:red'>Eg. Ask ChatGPT for instance to<b> Generate a Farmers Contracts Document Sample.</b> </span>


<input type="text" name="docs_prompt" id="docs_prompt" class="form-control docs_prompt" value="Generate a Legal Contracts Document Sample">


            </div>

<br>


  <div class="well">
    		<label>Quantity of Document Sample to be Generated by ChatGPT AI</label><br>


<div class='col-sm-4 ai_css'>
<input type="radio" id="docs_qty" name="docs_qty" value="1" class="docs_qty" />1<br>
</div>


<div class='col-sm-4 ai_css'>
<input type="radio" id="docs_qty" name="docs_qty" value="2" class="docs_qty" />2<br>
</div>

<div class='col-sm-4 ai_css'>
<input type="radio" id="docs_qty" name="docs_qty" value="3" class="docs_qty" checked/>3 <br>
</div>

</div>
<br>



  <div class="well">
    		<label>Maximum Character of Documents Text to be Generated by ChatGPT AI</label><br>


<div class='col-sm-3 ai_css'>
<input type="radio" id="docs_character" name="docs_character" value="200" class="docs_character" />200<br>
</div>

<div class='col-sm-3 ai_css'>
<input type="radio" id="docs_character" name="docs_character" value="250" class="docs_character" />250<br>
</div>


<div class='col-sm-3 ai_css'>
<input type="radio" id="docs_character" name="docs_character" value="300" class="docs_character" />300<br>
</div>


<div class='col-sm-3 ai_css'>
<input type="radio" id="docs_character" name="docs_character" value="600" class="docs_character"  checked/>600<br>
</div>


</div>

<br>

<div class='col-sm-12 form-group'>

<label>Documents Translating Language</label>
<select class='form-control trans_language' placeholder='Enter Translating Language'>
<option value=''>--Select--</option>
<option value='English'>English</option>
<option value='Korean'>Korean</option>
<option value='Turkish'>Turkish</option>
<option value='Portuguese'>Portuguese</option>
<option value='Spanish'>Spanish</option>
<option value='Hindi'>Hindi</option>
<option value='Arabic'>Arabic</option>
<option value='French'>French</option>
<option value='Bengali'>Bengali</option>
<option value='Russian'>Russian</option>
<option value='Japanese'>Japanese</option>
<option value='German'>German</option>
<option value='Indonesian'>Indonesian</option>
<option value='Italian'>Italian</option>
<option value='Viatnameese'>Viatnameese</option>
<option value='Urdu'>Urdu</option>
<option value='Telugu'>Telugu</option>
<option value='Chinese'>Chinese</option>
<option value='Latin'>Latin</option>

</select>
</div>
<br>


<div class="form-group">

                    <br>
<div id="loader_chatgpt"></div>



<button type="button" id="generate_chatgpt_btn" class="cat_cssa"  >Step1: Generate Documents Sample Via ChatGPT</button><br><br>
<div id="result_chatgpt"></div><br>

</div>





</p>


<br>
      </div>
<br><br>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Documents Modal ends -->










<script>
$(document).ready(function(){
//$('.btn_call').click(function(){
$(document).on( 'click', '.btn_call', function(){ 


var id = $(this).data('id');
var document_title = $(this).data('document_title');
var document_name = $(this).data('document_name');
var document_language = $(this).data('document_language');
var category = $(this).data('category');


$('.p_id').html(id);
$('.p_document_title').html(document_title);
$('.p_document_name').html(document_name);
$('.p_document_language').html(document_language);
$('.p_category').html(category);


$('.p_document_name_value').val(document_name).value;

$('.p_document_title_value').val(document_title).value;



});

});



$(document).ready(function(){
$('#sg_btn').click(function(){


var sign_title= $('.sign_title').val();
var sign_subject= $('.sign_subject').val();
var sign_message= $('.sign_message').val();
var sign_name= $('.sign_name').val();
var sign_email= $('.sign_email').val();
var doc_name= $('.p_document_name_value').val();		


if(doc_name==""){
alert('Documents Name Cannot be Empty.');
}

else if(sign_title==""){
alert('Documents Title Cannot be Empty.');
}
else if(sign_subject==""){
alert('Subject Cannot be Empty.');
}

else if(sign_message==""){
alert('Message Cannot be Empty.');
}
else if(sign_name==""){
alert('Signer Name Cannot be Empty.');
}
else if(sign_email==""){
alert('Signer Email Cannot be Empty.');
}

else{

$('#loader_sg').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="ajax-loader.gif">&nbsp;Please Wait, Sending Documents for Signing...</div>');
var datasend = {doc_name:doc_name, sign_title:sign_title, sign_subject:sign_subject, sign_message:sign_message, sign_name:sign_name, sign_email:sign_email};	
		$.ajax({
			
			type:'POST',
			url:'documents_signing_send_signature.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){
                        $('#loader_sg').hide();
                        $('#result_sg').html(msg);
setTimeout(function(){ $('#result_sg').html(''); }, 6000);

/*

//strip all html elemnts using jquery
var html_stripped = jQuery(msg).text();
//check occurrence of word (successful) from backend output already html stripped.
var Frombackend = html_stripped;
var bcount = (Frombackend.match(/successful/g) || []).length;
if(bcount > 0){
//$('.sign_title').val('');
//$('.sign_subject').val('');
//$('.sign_message').val('');
$('.sign_name').val('');
$('.sign_email').val('');
}
*/

			}
			
		});
		
		}
		
	})
					
});





</script>




<input type="hidden" class="p_document_name_value" value="">







<!--Send Documents start -->

<div id="myModal_sign" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header"   style='background: #008080;color:white;padding:10px;'>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Contracts Documents For Signing </h4>
      </div>

      <div class="modal-body">

        <p>  
<div class="form-group well">
<b>Document Title:</b> <span class='p_document_title'></span><br>
<b>Document Name:</b> <span class='p_document_name'></span><br>
<b>Document Language:</b> <b><span style='color:#008080' class='p_document_language'></span></b><br>
<b>Document Category:</b> <b><span style='color:purple' class='p_category'></span></b><br>

<br>
</div>

</p>

<p>
<div class='well'>
<div class="col-sm-12 form-group">
<label>Document Title</label>
<input type='text' class="form-control sign_title p_document_title_value" placeholder="Document Title"  value='' />
</div><br>



<div class="col-sm-12 form-group">
<label>Document Subject</label>
<input type='text' class="form-control sign_subject" placeholder="Document Subject"  value='This is Signing Document we Talk about' />
</div><br>



<div class="col-sm-12 form-group">
<label>Message</label>
<textarea rows="3" cols="3" class="form-control sign_message" placeholder="Message">
 Please Sign This Documents</textarea>
</div><br>

<div class="col-sm-12 form-group">
<label>Signer Name</label>
<input type='text' class="form-control sign_name" placeholder="Signer Name"  value='Esedo Fredrick' />
</div><br>

<div class="col-sm-12 form-group">
<label>Signer Email</label>
<input type='text' class="form-control sign_email" placeholder="Signer Email"  value='esedofredrick@gmail.com' />
</div><br>


<div class="form-group">
			<div id="loader_sg"></div>
</div>
<div class="form-group">
                        <div id="result_sg"></div>
                       </div>


<div class="form-group">
<button type="button" id="sg_btn" class="btn btn-primary cat_cssa"  >Send Documents For Signing</button><br><br>
</div>


</div>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Send Documents ends -->


<style>

#containerx {
  position: fixed;
  bottom: 0;
  right: 0;
  pointer-events: none;
}
.chat {
  border: 1px solid #999;
  display: inline-block;
  vertical-align: bottom;
  position: relative;
  margin: 0 5px;
  pointer-events: auto;
}
.title {
  padding: 10px;
  background-color: #008080;
  color: white;
border:none;
}
.text {
  padding: 10px;
}

</style>
<script> 
        $(document).ready(function() { 
            $("#tog_btn").click(function() { 
                $(".tog").toggle(); 
            }); 
        }); 



$(document).ready(function(){
$('#ask_chatgpt_btn').click(function(){
		
var questionx = $('.questionx').val();

if(questionx==""){
alert('ChatGPT Question Cannot be empty.');

}

else{

$('#loader_chat').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="ajax-loader.gif">&nbsp;Please Wait, ChatGPT Generation Response...</div>');
var datasend = {questionx:questionx};	
		$.ajax({
			
			type:'POST',
			url:'chatgpt_ask.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_chat').hide();
		$('#result_chat').fadeIn('slow').prepend(msg);

//$('#result_chat').fadeIn('slow').html(msg);

			$('.questionx').val('');
			}
			
		});
		
		}
		
	})
					
});
</script>


<p>


<div id="containerx" style="z-index: 1000">
 
  <div class="chat" style="z-index: 1000;background:#ccc">
    <div style='cursor:pointer;' id='tog_btn' class="title">Have Any Question About Documents? <b>Ask ChatGPT AI</b> <span style='float:right;color:orange;'><b>Toggle</b></span> </div>
    <div class="tog">

<div class="text" style="height:250px;min-width:450px;max-width:450px;">
     <span id="loader_chat"></span>
<span id="result_chat"></span>
    </div>

    <div class="chatbox" style="min-width:450px;max-width:450px;">

<div class="col-sm-10 form-group">
    <textarea class="form-control questionx" placehoder="Ask ChatGPT Any Question Regarding Your Signing Documents"></textarea>
</div>

<div class="col-sm-2 form-group">
<button type="button" id="ask_chatgpt_btn" class="cat_cssa"  >Chat ChatGPT</button><br><br>
</div>

    </div>

</div>
  </div>
</div>

</p>



</div>

</body>
</html>
