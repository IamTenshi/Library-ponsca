<?php
	require('../../lib/fpdf.php');
	require('../../config/config.php');

	class PDF extends FPDF {
			// Function to set fill color for header cells
			function HeaderCell($w, $h, $txt, $border = 0, $ln = 0, $align = 'L', $fill = false) {
					// Set fill color for header cells
					$this->SetFillColor(200, 220, 255);
					// Output the cell with the specified fill color
					$this->Cell($w, $h, $txt, $border, $ln, $align, true);
			}
	}

	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial', 'B', 16);

	// Image
	$imagePath = '../../assets/img/ponsca_logo.png';
	$imageWidth = 30;
	$imageX = ($pdf->GetPageWidth() - $imageWidth) / 2;
	$pdf->Image($imagePath, $imageX, 10, $imageWidth);

	// Title
	$title = 'Reporte de prestamos';
	$titleWidth = $pdf->GetStringWidth($title);
	$titleX = ($pdf->GetPageWidth() - $titleWidth) / 2;
	$titleY = 40; // Adjust this value to move the title up or down
	$pdf->SetXY($titleX, $titleY);
	$pdf->Cell($titleWidth, 20, $title);

	// Add space between title and table
	$pdf->Ln(20);

	$pdf->SetFont('Arial', 'B', 9);

	// Calculate the width of the table
	$tableWidth = 160; // 4 columns * 50 units width per column

	// Calculate the x position for the first cell to center the table
	$x = ($pdf->GetPageWidth() - $tableWidth) / 2;
	$pdf->SetX($x);

	// Header row
	$pdf->HeaderCell(40 ,10 ,'Book' ,1 ,0 ,'C');
	$pdf->HeaderCell(40 ,10 ,'User' ,1 ,0 ,'C');
	$pdf->HeaderCell(40 ,10 ,'Lending date' ,1 ,0 ,'C');
	$pdf->HeaderCell(40 ,10 ,'Lending devolution' ,1 ,0 ,'C');

	$pdf -> Ln();

	// Data rows
	// Query database for data
	$result = mysqli_query($conn,"SELECT * FROM `library`.`lendings`");

	while ($row = mysqli_fetch_array($result)) {
			$pdf -> SetX($x);
			$pdf -> Cell(40 ,10 ,$row['book_name'] ,1 ,0 ,'C');
			$pdf -> Cell(40 ,10 ,$row['users_username'] ,1 ,0 ,'C');
			$pdf -> Cell(40 ,10 ,$row['lending_date'] ,1 ,0 ,'C');
			$pdf -> Cell(40 ,10 ,$row['devolution_date'] ,1 ,0 ,'C');
			$pdf -> Ln();
	}

	$pdf -> Output();
?>