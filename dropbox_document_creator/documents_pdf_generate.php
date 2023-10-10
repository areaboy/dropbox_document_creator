<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// temporarly extend time limit
set_time_limit(300);

error_reporting(0);

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');
include('data6rst.php');

$title= strip_tags($_POST['titlex']);
$message= strip_tags($_POST['messagex']);
$category= strip_tags($_POST['categoryx']);
$trans_language= strip_tags($_POST['trans_language']);
$filename= strip_tags($_POST['filenamex']);


//$titlex ="$tit Sample in $trans_language";

$timer =time();

$mt_id=rand(0000,9999);
$file_name1 = str_replace(' ', '-', $filename);
$filename_pdf = "$file_name1-$mt_id.pdf";


if($title == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents Title is Empty</div><br>";
exit();
}

if($message == ''){
echo "<div style='background:red;color:white;padding:10px;border:none;'>Documents Body is Empty</div><br>";
exit();
}

// generate pdf

require('../fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetTitle($title);


$content =$message;
// Arial bold 22
$pdf->SetFont('Arial','B',22);
$w = $pdf->GetStringWidth($title)+6;
$pdf->SetX((210-$w)/2);
$pdf->Write(5,$title);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',14);
$pdf->Write(5,$content);

// save file to a directory
$pdf->Output("documents_pdf/$filename_pdf", 'F');
// save file as download
//$pdf->Output('mypdf.pdf', 'D');



// insert to database

$statement = $db->prepare('INSERT INTO documents_docs

(document_name,category, document_title,document_text,document_type,document_language,timing)
 
                          values
(:document_name,:category, :document_title,:document_text,:document_type,:document_language,:timing)');

$statement->execute(array( 
':document_name' => $filename_pdf,
':category' => $category,
':document_title' => $title,		
':document_text' =>$message,
':document_type' =>'Dropbox',
':document_language' =>$trans_language,
':timing' => $timer
));

$document_id = $db->lastInsertId();

if($statement){
echo "<div class='col-sm-12 form-group'>
<div style='background:green;color:white;padding:10px;border:none;'>Document PDF Successfully Created..</div></div><br>
<script>alert('Document PDF Successfully Created..'); location.reload();</script>
";

}else{
echo "<div class='col-sm-12 form-group'><div style='background:red;color:white;padding:10px;border:none;'>Document PDF Creation Failed..</div></div><br>";

}



}
else{
echo "<div id='' style='background:red;color:white;padding:10px;border:none;'>
Direct Page Access not Allowed<br></div>";
}


?>
