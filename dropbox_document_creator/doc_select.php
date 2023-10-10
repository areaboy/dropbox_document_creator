
<?php


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

error_reporting(0);


session_start();
include ('authenticate.php');

$userid =  htmlentities(htmlentities($_SESSION['uid2'], ENT_QUOTES, "UTF-8"));
$fullname =  htmlentities(htmlentities($_SESSION['fullname2'], ENT_QUOTES, "UTF-8"));
$email =  htmlentities(htmlentities($_SESSION['email2'], ENT_QUOTES, "UTF-8"));


if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');
include('data6rst.php');




$result_verified = $db->prepare('select * from documents');
$result_verified->execute(array());

$count = $result_verified->rowCount();


if($count ==0){
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>No Documents Uploaded Yet. Try and Upload Documents and Files</div>";
//exit();
}



 echo '<div class="form-group">
              <label>Select Document/Files : </label>
             <select name="docname" id="docname" class="docname col-sm-12 form-control">
    <option value="">Select Documents/Files</option>';


while($row = $result_verified->fetch()){


$docs = $row['document_extraction'];
$docs_name = $row['document_name'];
$docs_title = $row['document_title'];

?>
    <option value="<?php echo $docs_name; ?>" ><?php echo $docs_title; ?>(<?php echo $docs_name; ?>) </option>
   <?php
    }
    ?>
</select></div><br>

<?php

}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}



?>
