
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
$pdf->SetFont('Arial','',12); 
  
// Move to the right 
$pdf->Cell(80); 
  
// Line break 
$pdf->Ln(40); 

//First Paragraph
$pdf->Cell(40,10,'Old Dominion Humane Society');
$pdf->Ln(5); 
$pdf->Cell(40,10,'3602 Lafayette Blvd. Ste. 102');
$pdf->Ln(5); 
$pdf->Cell(40,10,'Fredericksburg, VA 22408');
$pdf->Ln(5);
$pdf->Cell(40,10,'To Whom It May Concern:');
$pdf->Ln(10);
$pdf->Cell(40,10,'Old Dominion Humane Society is a volunteer organization dedicated to providing a better life');
$pdf->Ln(5);
$pdf->Cell(40,10, 'for dogs through adoption and education as well as to assist in the effort to limit the');
$pdf->Ln(5);
$pdf->Cell(40,10,'overpopulation of these animals through a spay and neuter program.');
$pdf->Ln(10);

//Second Paragraph
$pdf->Cell(40,10,'[FIRST NAME LAST NAME] self-reports that he volunteered for [NUMBER] hours between');
$pdf->Ln(5);
$pdf->Cell(40,10,'[OLDEST DATE LOGGED] and [MOST RECENT DATE LOGGED] with our rescue completing several');
$pdf->Ln(5);
$pdf->Cell(40,10,'tasks which include the following: walking dogs, cleaning kennels, cleaning dishes, washing and');
$pdf->Ln(5);
$pdf->Cell(40,10,'folding laundry, and socializing with the dogs. [PERSON] has contributed wonderfully to our');
$pdf->Ln(5);
$pdf->Cell(40,10,'organization.');
$pdf->Ln(10);

//Table of Hours
$pdf->Cell(40,10,"The following is a record of [PERSON]'s self-reported hours:");
$pdf->Ln(10);

//Contact
$pdf->Cell(40,10,"If you have any questions please contact us at volunteer@olddominionhumanesociety.org for");
$pdf->Ln(5);
$pdf->Cell(40,10,"additional information.");
$pdf->Output(); 
  
?>

