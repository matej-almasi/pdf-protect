<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'generate-drmed-pdf.php';


add_action( 'woocommerce_download_product', 'intercept_and_serve_drmed_pdf', 10, 6 );

function intercept_and_serve_drmed_pdf( $user_email, $order_key, $product_id, $user_id, $download_id, $order_id ) {
    // Get order and product objects
    $order = wc_get_order( $order_id );
    $product = wc_get_product( $product_id );

    // Get the file URL (WooCommerce stores downloadable files as an array)
    $downloads = $product->get_downloads();
    if ( isset( $downloads[ $download_id ] ) ) {
        $file_url = $downloads[ $download_id ]->get_file();
        $file_path = get_attached_file( attachment_url_to_postid( $file_url ) ); // Resolve actual file path

        // Ensure the file exists and is a PDF
        if ( $file_path && pathinfo( $file_path, PATHINFO_EXTENSION ) === 'pdf' ) {
            // Serve DRM-protected file dynamically
            serve_drmed_pdf( $file_path, $order);
            exit; // Prevent default WooCommerce handling
        }
    }
}
