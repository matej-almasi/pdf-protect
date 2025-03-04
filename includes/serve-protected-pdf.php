<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use setasign\Fpdi\Tfpdf;

// Include the DRM text template
require_once 'generate-data-rights.php';

function serve_protected_pdf( $original_file_path, $order ) {
    // Start output buffering
    ob_start();
	
    // TODO: Change this to match your upload
	// The uploads subdirectory containing our ttf font
	define( 'YEAR_MONTH', '/2025/03/');

    // TODO: Change this to match your uploaded font
	// The font file and name
    define( 'FONT_FILE', 'Oswald-Regular.ttf');
    define( 'FONT_NAME', 'Oswald');
	
    // This is used by the TFPDF when looking for fonts
	define('_SYSTEM_TTFONTS', wp_upload_dir()['basedir'] . YEAR_MONTH);
	
    $drm_text = generate_data_rights( $order );

    // Initialize FPDI
    $pdf = new Tfpdf\Fpdi();
    $page_count = $pdf->setSourceFile( $original_file_path );
    
    // Import first page
    $tpl = $pdf->importPage( 1 );
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    $pdf->useTemplate( $tpl );

    // Add DRM text on page 2
    $pdf->SetMargins(20, 20);
    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    $pdf->AddFont(FONT_NAME, '' , FONT_FILE, true);
    $pdf->SetFont(FONT_NAME, '', 10 );
    $pdf->MultiCell( 0, 8, $drm_text );

    // Append the rest of the original PDF pages
    for ($i = 2; $i <= $page_count; $i++) {
        $tpl = $pdf->importPage( $i );
        $size = $pdf->getTemplateSize($tpl);
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($tpl);
    }

    // Clean output buffer
    ob_clean();

    // Serve the modified file as a response
    $file_name = pathinfo( $original_file_path, PATHINFO_FILENAME );
    $pdf->Output( 'D', $file_name . '.pdf');
}
