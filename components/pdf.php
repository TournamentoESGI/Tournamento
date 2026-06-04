<?php
require_once('./libs/fpdf/fpdf.php');

function exportPDF($titre, $lignes) {
    ob_end_clean();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, $titre, 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);

    foreach($lignes as $ligne) {
        $pdf->Cell(0, 8, $ligne, 0, 1);
    }
    $pdf->Output('D', $titre . '.pdf');
    exit;
}

?>