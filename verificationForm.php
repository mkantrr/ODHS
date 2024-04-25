
<?php 
  
require('fpdf/fpdf.php'); 

//Created by Niko Toro
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    $isAdmin = $accessLevel >= 2;
    require_once('database/dbPersons.php');
    require_once('database/dbHours.php');
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
        $viewingSelf = $id == $userID;
    } else {
        $id = $_SESSION['_id'];
        $viewingSelf = true;
    }
    $volunteer = retrieve_person($id);
    $volunteerName = get_name_from_id($id);
    $email = get_email_from_id($id);
    $totalHours = total_hours($email);
    $hours = retrieve_hours_by_email($email);
    $first_date = get_first_date($email);
    $last_date = get_last_date($email);


    $num_of_rows = mysqli_num_rows($hours);
    $col_userEmail = "";
    $col_date = "";
    $col_time = "";
    $col_duration = "";

    while ($row = mysqli_fetch_assoc($hours)) {
        $date = $row["date"];
        $time = $row["time"];
        $duration = $row["duration"];

        $col_date = $col_date.$date."\n";
        $col_time = $col_time.$time."\n";
        $col_duration = $col_duration.$duration."\n";
    }
  
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
$pdf->Ln(15);
$pdf->Cell(40,10,'To Whom It May Concern:');
$pdf->Ln(10);
$pdf->Cell(40,10,'Old Dominion Humane Society is a volunteer organization dedicated to providing a better life');
$pdf->Ln(5);
$pdf->Cell(40,10, 'for dogs through adoption and education as well as to assist in the effort to limit the');
$pdf->Ln(5);
$pdf->Cell(40,10,'overpopulation of these animals through a spay and neuter program.');
$pdf->Ln(10);

//Second Paragraph
while ($result_row = mysqli_fetch_assoc($totalHours)) {
    $field1name = $result_row["SUM(duration)"];
$pdf->Cell(40,10,'' . $volunteerName . ' self-reports that they volunteered for ' . $field1name . ' hours between');
}
$pdf->Ln(5);
$pdf->Cell(40,10,'' . $first_date . ' and '. $last_date . ' with our rescue completing several taskes which include the');
$pdf->Ln(5);
$pdf->Cell(40,10,'following: walking dogs, cleaning kennels, cleaning dishes, washing and folding laundry,');
$pdf->Ln(5);
$pdf->Cell(40,10,'and socializing with the dogs. ' . $volunteerName . ' has contributed wonderfully to our organization');
$pdf->Ln(10);

//Table of Hours
$pdf->Cell(40,10,"The following is a record of " . $volunteerName . "'s self-reported hours:");
$pdf->Ln(10);

$pdf->SetFillColor(232,232,232);
//Fields Name position
$Y_Fields_Name_position = 145;
//Table position, under Fields Name
$Y_Table_Position = 151;
$pdf->SetFont('Arial','B',12);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(45);
$pdf->Cell(20,6,'HOURS',1,0,'L',1);
$pdf->SetX(65);
$pdf->Cell(70,6,'DATE',1,0,'L',1);
$pdf->SetX(105);
$pdf->Cell(30,6,'TIME',1,0,'L',1);
$pdf->Ln();

$pdf->SetFont('Arial','',12);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(20,6,$col_duration,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(65);
$pdf->MultiCell(70,6,$col_date,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(105);
$pdf->MultiCell(30,6,$col_time,1,'L');

//Create lines (boxes) for each ROW (Product)
//If you don't use the following code, you don't create the lines separating each row
$i = 0;
$pdf->SetY($Y_Table_Position);
while ($i < $num_of_rows)
{
    $pdf->SetX(45);
    $pdf->MultiCell(90,6,'',1);
    $i = $i +1;
}
//Contact
$pdf->Ln(5);
$pdf->Cell(40,10,"If you have any questions please contact us at volunteer@olddominionhumanesociety.org for");
$pdf->Ln(5);
$pdf->Cell(40,10,"additional information.");


$pdf->Output(); 
  
?>

