
<?php 

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('data6rst.php');
$document_type ='Dropbox';



// get total count
$pstmt = $db->prepare('SELECT * FROM documents_docs where document_type=:document_type');
$pstmt->execute(array(':document_type' =>$document_type));
$total_count = $pstmt->rowCount();

// ensure that they cotain only alpha numericals
if(strip_tags(isset($_POST["get_content"]))){
$get_content = strip_tags($_POST["get_content"]);
if($get_content == 'get_data'){

$sql_query = '';
$error = '';
$message='';
$response_bl = array();

$sql_query .= "SELECT * FROM documents_docs ";
if(strip_tags(isset($_POST["search"]["value"]))){

//$search_value= strip_tags($_POST["search"]["value"]);
$search_value1= strip_tags($_POST["search"]["value"]);
$search_value=  htmlentities(htmlentities($search_value1, ENT_QUOTES, "UTF-8"));
$sql_query .= 'WHERE (document_type =:document_type) AND  (document_language LIKE "%'.$search_value.'%"  OR document_name LIKE "%'.$search_value.'%"  OR  category LIKE "%'.$search_value.'%" OR document_title LIKE "%'.$search_value.'%")';
  }


//ensure that order post is set
$start = $_POST['start'];
$length = $_POST['length'];
$draw= $_POST["draw"];
if(strip_tags(isset($_POST["order"]))){
$order_column = strip_tags($_POST['order']['0']['column']);
$order_dir = strip_tags($_POST['order']['0']['dir']);

$sql_query .= 'ORDER BY '.$order_column.' '.$order_dir.' ';
}
else{
$sql_query .= 'ORDER BY id DESC ';
}
if($length != -1){
$sql_query .= 'LIMIT ' . $start . ', ' . $length;
}

$pstmt = $db->prepare($sql_query);
$pstmt->execute(array(':document_type' =>$document_type));
$rows_count = $pstmt->rowCount();

//$result = $pstmt->fetchAll();
//foreach($result as $row){
while($row = $pstmt->fetch()){
$rows1 = array();
$id = $row['id'];
$document_name = $row['document_name'];
$category = $row['category'];
$document_title = $row['document_title'];
$timing = $row["timing"];
$document_text = $row["document_text"];
$document_language = $row["document_language"];



if($category == 'Farmers Documents'){
$cat = "<div class='red_css'>Farmers Documents</div>";
//$colorx ="red_css";
}

if($category == 'Legal Documents'){
$cat = "<div class='green_css'>Legal Documents</div>";
//$colorx ="red_css";
}

if($category == 'Contract Documents'){
$cat = "<div class='purple_css'>Contract Documents</div>";
//$colorx ="red_css";
}

if($category == 'Business Documents'){
$cat = "<div class='fuchsia_css'>Business Documents</div>";
//$colorx ="red_css";
}




$rows1[] = "<span style='color:#008080'>$document_title</span>";
$rows1[] = $document_name."<br><button class='c_css'><a target='_blank' class='c_css' href='documents_pdf/$document_name' title='View Generated Documents' >
View Generated Documents</a></button>";
$rows1[] = "<b style='color:#008080'>$document_language</b>";
$rows1[] = $cat;
$rows1[] = '<span data-livestamp="'.$timing.'"></span>';
$rows1[] = "<button type='button'  class='btn btn-primary btn-xs btn_call'  data-toggle='modal' data-target='#myModal_sign'
data-id='$id'
data-document_title='$document_title'
data-document_name='$document_name'
data-document_language='$document_language'
data-category='$category'
>Send Documents For Signing </button>";





$response_bl[] = $rows1;
}

$data = array(
"draw"    => $draw,
"recordsTotal"  => $rows_count,
"recordsFiltered" => $total_count,
"data"    => $response_bl);
}// you can close this



 echo json_encode($data);
}



}
else{
echo "<div id='alertdata_uploadfiles' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}




?>