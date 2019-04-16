<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";

    $hauling_no = $_GET['hauling_no'];
    $sql = "SELECT * FROM hauling 
    WHERE hauling_no = '$hauling_no';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $pdf = new FPDF();
    $pdf->SetMargins(20,20,20);
    $pdf->AddPage();
    
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'NEW GOLDEN CITY BUILDERS & DEV. CORP.',0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,0,'1388 Icasiano St. Cor. Gernali St. Paco Manila',0,1,'C');
    $pdf->Cell(0,10,'Tels. 564-1921 to 25 Fax 563-6610',0,1,'C');
    
    $pdf->SetFont('Times','U',17);
    $pdf->Cell(0,30,'HAULING RECEIPT');
    $pdf->SetXY($pdf->GetX()-70,$pdf->GetY()+15);
    $pdf->SetFont('Times','I',15);
    $pdf->Cell(0,0,'Date:');
    $pdf->SetFont('Times','',14);
    $pdf->SetXY($pdf->GetX()-55,$pdf->GetY());
    $pdf->Cell(5,0,$row[1]);
    $pdf->SetXY($pdf->GetX()-6,$pdf->GetY()+3);
    $pdf->Cell(40,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->SetFont('Times','I',15);
    $pdf->Cell(0,30,'Deliver to');
    $pdf->SetFont('Times','',14);
    $pdf->SetXY($pdf->GetX()-140,$pdf->GetY()+15);
    $pdf->Cell(5,0,$row[2]);
    $pdf->SetXY($pdf->GetX()-10,$pdf->GetY()+3);
    $pdf->Cell(75,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->SetFont('Times','I',15);
    $pdf->Cell(0,15,'Hauled from');
    $pdf->SetFont('Times','',14);
    $pdf->SetXY($pdf->GetX()-135,$pdf->GetY()+8);
    $pdf->Cell(5,0,$row[3]);
    $pdf->SetXY($pdf->GetX()-10,$pdf->GetY()+3);
    $pdf->Cell(70,0,"",1,0,'L',true);
    $pdf->Ln();
    
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(0,0,0);

    $pdf->SetY($pdf->GetY()+10);
    $pdf->Cell(30,8,'Qty.',1,0,'C',true);
    $pdf->Cell(30,8,'Unit',1,0,'C',true);
    $pdf->Cell(107,8,'ARTICLES',1,0,'C',true);
    $pdf->Ln();

    $sql_table = "SELECT hauling_quantity, hauling_unit, hauling_matname FROM hauling WHERE hauling_no = '$hauling_no';";
    $result_table = mysqli_query($conn, $sql_table);
    
    
   while ($row_table = mysqli_fetch_row($result_table)) {
        $pdf->Cell(30,8,$row_table[0],1,0,'C',true);
        $pdf->Cell(30,8,$row_table[1],1,0,'C',true);
        $pdf->Cell(107,8,$row_table[2],1,0,'C',true);
        $pdf->Ln();
    }
    
    $pdf->SetFont('Times','I',15);
    $pdf->Cell(0,20,'Requested:');
    // $pdf->Cell(0,0,'Form No:',0,1);
    // $pdf->SetFontSize(13);
    // $pdf->SetTextColor(50,50,50);
    // $pdf->SetXY($pdf->GetX()-200,$pdf->GetY()+2);
    // $pdf->Cell(0,15,$row[1]);
    // $pdf->SetXY($pdf->GetX()-60,$pdf->GetY());
    // $pdf->Cell(0,15,$row[0],0,1);
    // $pdf->SetXY($pdf->GetX()+2,$pdf->GetY()-2);
    // $pdf->Cell(100,0," ",1,0,'L',true);
    // $pdf->SetXY($pdf->GetX()+19.5,$pdf->GetY());
    // $pdf->Cell(40,0," ",1,0,'L',true);
    // $pdf->Ln();
    
    // $pdf->SetFontSize(17);
    // $pdf->SetTextColor(169,169,169);
    // $pdf->Cell(0,40,'Deliver To:');
    // $pdf->SetFontSize(13);
    // $pdf->SetTextColor(50,50,50);
    // $pdf->SetXY($pdf->GetX()-180,$pdf->GetY()+30);
    // $pdf->Cell(0,0,$row[2],0,1);
    // $pdf->SetXY($pdf->GetX()+2,$pdf->GetY()+5);
    // $pdf->Cell(100,0," ",1,1,'L',true);

    // $pdf->SetFontSize(17);
    // $pdf->SetTextColor(169,169,169);
    // $pdf->Cell(0,40,'Hauled From:');
    // $pdf->SetFontSize(13);
    // $pdf->SetTextColor(50,50,50);
    // $pdf->SetXY($pdf->GetX()-180,$pdf->GetY()+30);
    // $pdf->Cell(0,0,$row[3],0,1);
    // $pdf->SetXY($pdf->GetX()+2,$pdf->GetY()+5);
    // $pdf->Cell(100,0," ",1,1,'L',true);
    
    // $pdf->SetFont('Arial','B',13);
    // $pdf->SetTextColor(50,50,50);
    // $pdf->Cell(0,40,'Quantity');

    

    

    //OUTPUT TO PDF
    // $pdf->Output('D', "INVENTORY REPORT ".date("F Y").".pdf");
    $pdf->Output();
?>