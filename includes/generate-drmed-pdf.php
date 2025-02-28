<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use setasign\Fpdi\Tfpdf;

// Include the DRM text template
require_once 'drm-text-template.php';

function serve_drmed_pdf( $original_file_path, $order ) {
    $drm_text = generate_drm_text( $order );

    // Initialize FPDI
    $pdf = new Tfpdf\Fpdi();
    $pdf->AddPage();
    $page_count = $pdf->setSourceFile( $original_file_path );

    // Import first page
    $tpl = $pdf->importPage( 1 );
    $pdf->useTemplate( $tpl );

    // Add DRM text on page 2
    $pdf->AddPage();
    $pdf->AddFont('DejaVu','','DejaVuSans.ttf', true);
    $pdf->SetFont( 'DejaVu', '', 12 );
    $pdf->SetXY( 10, 10 );
    $pdf->MultiCell( 0, 10, $drm_text );

    // Append the rest of the original PDF pages
    for ($i = 2; $i <= $page_count; $i++) {
        $pdf->AddPage();
        $tpl = $pdf->importPage( $i );
        $pdf->useTemplate($tpl, 0, 0 );
    }

    // Serve the modified file as a response
    $file_name = pathinfo( $original_file_path, PATHINFO_FILENAME );
    $pdf->Output( 'D', $file_name . '.pdf');
    exit;
}
