<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";

    //INITIALIZATION OF FPDF OBJECT
    $pdf = new FPDF();
    $pdf->AddPage();
    
    //PAGE TITLE
    $pdf->SetFont('Times','B',16);
    $pdf->Cell(0,10,'NEW GOLDEN CITY BUILDERS AND DEVELOPMENT',0,1,'C');
    $pdf->Cell(0,3,'CORPORATION',0,1,'C');
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,utf8_decode('CONTRACTORS '.chr(127).' ENGINEERS '.chr(127).' CONSULTANT'),0,2,'C');

    //PROJECT Details
    $projects_name = $_GET['projects_name'];
    $sql = "SELECT projects_name , projects_address FROM projects 
    WHERE projects_name = '$projects_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,25,'PROJECT : '.strtoupper($row[0]),0,2);
    $pdf->Cell(0,-16,'LOCATION : '.strtoupper($row[1]),0,2);
    $pdf->Cell(0,26,'SUBJECT : INVENTORY REPORT AS OF '.date("F Y"),0,2);

    //SET TABLE BORDER COLOR
    $pdf->SetFont('Times','B',9);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(0,0,0);
    
    //TABLE HEADER
    $pdf->MultiCell(50,26.67,'PARTTICULARS',1,'C',true);
    $pdf->SetXY($pdf->GetX()+50,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,8.9,utf8_decode('PREVIOUS'.chr(10).'MATERIAL'.chr(10).'STOCK'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+72,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,6.67,utf8_decode('DELIVERED'.chr(10).'MATERIAL'.chr(10).'AS OF'.chr(10).'April 2019'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+94,$pdf->GetY()-26.67);
    $pdf->MultiCell(31,8.9,utf8_decode('MATERIAL'.chr(10).'PULLED OUT'.chr(10).'AS OF April 2019'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+125,$pdf->GetY()-26.67);
    $pdf->MultiCell(29,8.9,utf8_decode('ACCUMULATED'.chr(10).'MATERIALS'.chr(10).'DELIVERED'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+154,$pdf->GetY()-26.67);
    $pdf->MultiCell(35,13.33,utf8_decode('MATERIALS ON SITE'.chr(10).'AS OF April 2019'),1,'C',true);
  
    //TABLE CONTENT
    $sql_categ = "SELECT DISTINCT categories.categories_name FROM materials 
                    INNER JOIN categories ON materials.mat_categ = categories.categories_id
                    INNER JOIN projects ON materials.mat_project = projects.projects_id
                    WHERE projects.projects_name = '$projects_name'
                    ORDER BY categories.categories_name;";
    $result = mysqli_query($conn, $sql_categ);

    $categories = array();

    while($row_categ = mysqli_fetch_assoc($result)){
        $categories[] = $row_categ;
    }

    foreach($categories as $data) {
        $categ = $data['categories_name'];
        $sql = "SELECT 
        materials.mat_name, 
        materials.mat_prevStock, 
        unit.unit_name
        FROM materials 
        INNER JOIN categories ON materials.mat_categ = categories.categories_id
        INNER JOIN projects ON materials.mat_project = projects.projects_id
        INNER JOIN unit ON materials.mat_unit = unit.unit_id
        WHERE categories.categories_name = '$categ' && projects.projects_name = '$projects_name'
        ORDER BY materials.mat_name;";
        $pdf->SetFont('Times','B',9);
        $pdf->Cell(189,0.75," ",1,0,'L',true);
        $pdf->Ln();
        $pdf->Cell(189,10,strtoupper($categ).":",1,0,'L',true);
        $pdf->Ln();
        $pdf->Cell(189,0.75," ",1,0,'L',true);
        $pdf->Ln();
        $result = mysqli_query($conn, $sql);
        $pdf->SetFont('Times','',9);
        while($row = mysqli_fetch_row($result)){
            $sql1 = "SELECT SUM(delivered_quantity) FROM deliveredin
                    INNER JOIN materials ON deliveredin.delivered_matName = materials.mat_id
                    WHERE materials.mat_name = '$row[0]';";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_row($result1);
            $sql2 = "SELECT SUM(usage_quantity) FROM usagein
            INNER JOIN materials ON usagein.usage_matName = materials.mat_id
            WHERE materials.mat_name = '$row[0]';";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_row($result2);
            $pdf->Cell(50,10,$row[0],1,0,'C',true);
            $pdf->Cell(12,10,$row[1],1,0,'C',true);
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            if($row1[0] == null) {
                $pdf->Cell(22,10,0,1,0,'C',true);
            } else {                
                $pdf->Cell(22,10,$row1[0],1,0,'C',true);
            } 
            if($row2[0] == null) {
                $pdf->Cell(21,10,0,1,0,'C',true);
            } else {                
                $pdf->Cell(21,10,$row2[0],1,0,'C',true);
            }
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            $pdf->Cell(29,10,$row[1]+$row1[0],1,0,'C',true);
            $pdf->Cell(25,10,($row[1]+$row1[0])-$row2[0],1,0,'C',true);
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            $pdf->Ln();
        }

        
    }
    //OUTPUT TO PDF
    $pdf->Output('D', "INVENTORY REPORT ".date("F Y").".pdf");
?>