<?php

include 'PDFMerger/PDFMerger.php';

$pdf = new PDFMerger;
foreach($_POST as $file){
  $pdf->addPDF($file, 'all'); 
}
echo $file="merge_".uniqid().".pdf";
$pdf->merge('file', 'uploads/pdf/'.$file);


?>