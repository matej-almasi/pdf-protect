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
    $pdf->setSourceFile( $original_file_path );

    // Import first page
    $tplId = $pdf->importPage( 1 );
    $pdf->useTemplate( $tplId, 0, 0, 210 );

    // Add DRM text on page 2
    $pdf->AddPage();
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->SetXY( 10, 10 );
    $pdf->MultiCell( 0, 10, $drm_text );

    // Serve the modified file as a response
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="protected.pdf"');
    $pdf->Output( 'I' ); // Inline display; use 'D' to force download
    exit;
}
