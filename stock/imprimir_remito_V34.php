<?php
require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');

/*IMPRIMIR REMITO*/
// initiate FPDI
//echo $id1; 
//header ("Location: edu.php");
            $pdf =& new FPDI();
// add a page
$pdf->AddPage();

// now write some text above the imported page
$pdf->SetFont('courier');
$pdf->SetTextColor(0,0,0);
$pdf->SetFontSize(10);

$pdf->SetXY(170, 27);
$pdf->Write(0, "EDUARDO");
$pdf->Output();
$pdf->Close();
          

?>