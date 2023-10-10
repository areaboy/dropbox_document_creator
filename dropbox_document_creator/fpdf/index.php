<?php
error_reporting(0);
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$title = 'Contracts Agreements Powered by Dropbox';
$pdf->SetTitle($title);

/*
 // Arial bold 15
    $pdf->SetFont('Arial','B',15);
$w = $pdf->GetStringWidth($title)+6;
    $pdf->SetX((210-$w)/2);

  // Colors of frame, background and text
    $pdf->SetDrawColor(0,80,180);
    $pdf->SetFillColor(230,230,0);
    $pdf->SetTextColor(220,50,50);
    // Thickness of frame (1 mm)
    $pdf->SetLineWidth(1);
    // Title
    $pdf->Cell($w,9,$title,1,1,'C',true);
    // Line break
    $pdf->Ln(10);
*/

// Arial bold 12
$titlex ='Legal Contracts Agreements By Dropbox';







$content ="This Letter of Mutual Non-Disclosure Agreement is made between Esedo Fredrick and ABC Company with its principal offices at 123 Alphabet Street, San Francisco, CA 94101,located at 34 Yanco Street, San Francisco, CA. 
for the purpose of preventing the unauthorized disclosure of Confidential Information as defined below.

The parties agree to enter into a confidential relationship with respect to the disclosure of certain proprietary and confidential information.
This agreement is witnessed  by Mike Clare and Moree Natalia. 

This Mutual agreement is hereby entered into by ABC Corps and Esedo Fredrick on this date 27 of Oct 2021.

Both parties hereby agree to the following terms and conditions in relation to this agreement

1. Recipient Esedo Fredrick desires to receive services from ABC Company and ABC Company desires to provide said services to Recipient
Both parties hereby agree to the following terms and conditions in relation to this agreement.


2. To protect the information shared between ABC Corps and  Esedo Fredrick .Other Companies involves includes, Fredjarsofts PLC,Tony Brook Insurance and Ann Ball Legal Team and  All information  involved. 
Ann Ball and Contracting Agents at ABC Corp.This agreement shall be governed under the jurisdict on of the stateof Alabama, United States of America.

Term: This agreement shall be effective as of the date of execution and shall remain in effect until completion of services
IN WITNESS WHEREOF,
this Letter of Agreement has been executed by the parties on the date written above.

Recipient Name: Esedo Fredrick.
Company Name: ABC Corps respectively.
";

$pdf->SetFont('Arial','B',26);
$w = $pdf->GetStringWidth($titlex)+6;
$pdf->SetX((210-$w)/2);
$pdf->Write(5,$titlex);
//$pdf->Cell(40,10,'Contracts Agreements Sample Powered by Dropbox');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',14);
$pdf->Write(5,$content);
//$pdf->Cell(60,10,$content,0,1,'C');
//$pdf->Output();
// save file to a directory
$pdf->Output('downloads/contracts.pdf', 'F');
// save file as download
//$pdf->Output('mypdf.pdf', 'D');
?>