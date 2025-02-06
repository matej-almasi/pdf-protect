<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use setasign\Fpdi\Fpdi;

function serve_drmed_pdf( $original_file_path, $order, $user_email ) {
    $order_id = $order->get_id();
    $drm_text = "Purchased by: $user_email\nOrder ID: $order_id";

    // Initialize FPDI
    $pdf = new Fpdi();
    $pdf->AddPage();
    $page_count = $pdf->setSourceFile( $original_file_path );

    // Import first page
    $tplId = $pdf->importPage( 1 );
    $pdf->useTemplate( $tplId, 0, 0, 210 );

    // Add DRM text on page 2
    $pdf->AddPage();
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->SetXY( 10, 10 );
    $pdf->MultiCell( 0, 10, $drm_text );

    // Append the rest of the original PDF pages
    for ($i = 2; $i <= $page_count; $i++) {
        $pdf->AddPage();
        $tpl = $pdf->importPage( $i );
        $pdf->useTemplate($tpl, 0, 0, 210 );
    }

    // Serve the modified file as a response
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="protected.pdf"');
    $pdf->Output( 'D' ); // Inline display; use 'D' to force download
    exit;
}
