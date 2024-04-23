
<?php 
  
require('fpdf/fpdf.php'); 
  
class PDF extends FPDF { 
  
    // Page footer 
    function Footer() { 
          
        // Position at 1.5 cm from bottom 
        $this->SetY(-15); 
          
        // Arial italic 8 
        $this->SetFont('Arial','I',8); 
          
        // Page number 
        $this->Cell(0,10,'Page ' .  
            $this->PageNo() . '/{nb}',0,0,'C'); 
    } 
} 
  
// Instantiation of FPDF class 
$pdf = new PDF(); 

// Define alias for number of pages 
$pdf->AliasNbPages(); 
$pdf->AddPage(); 

// Add logo to page 
$pdf->Image('images/odhs.png',50,8,100); 
          
// Set font family to Arial bold  
$pdf->SetFont('Arial','',20); 
  
// Move to the right 
$pdf->Cell(80); 
  
// Line break 
$pdf->Ln(40); 

$pdf->Cell(40,10,'Old Dominion Humane Society');
$pdf->Ln(10); 
$pdf->Cell(40,10,'3602 Lafayette Blvd. Ste. 102');
$pdf->Ln(10); 
$pdf->Cell(40,10,'Fredericksburg, VA 22408');
$pdf->Output(); 
  
?>

