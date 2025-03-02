<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'serve-protected-pdf.php';

function add_email_log_handler( $handlers ) {
	$recipients = array( 'support@templateshop.com' );
	$threshold  = 'error';
	$handlers[] = new WC_Log_Handler_Email( $recipients, $threshold );
	return $handlers;
}
add_filter( 'woocommerce_register_log_handlers', 'add_email_log_handler' );

add_action( 'woocommerce_download_product', 'intercept_and_serve_protected_pdf', 10, 6 );

function intercept_and_serve_protected_pdf( $user_email, $order_key, $product_id, $user_id, $download_id, $order_id ) {
    $logger = wc_get_logger();
    
    try {
        // Get order and product objects
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            throw new Exception( sprintf( 'Order %d not found', $order_id ) );
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            throw new Exception( sprintf( 'Product %d not found', $product_id ) );
        }

        // Get the file URL (WooCommerce stores downloadable files as an array)
        $downloads = $product->get_downloads();
        if ( ! isset( $downloads[ $download_id ] ) ) {
            throw new Exception( sprintf( 'Download ID %s not found for product %d', $download_id, $product_id ) );
        }

        $file_url = $downloads[ $download_id ]->get_file();
        $attachment_id = attachment_url_to_postid( $file_url );
        
        if ( ! $attachment_id ) {
            throw new Exception( sprintf( 'Could not resolve attachment ID for URL: %s', $file_url ) );
        }

        $file_path = get_attached_file( $attachment_id );
        
        if ( ! $file_path ) {
            throw new Exception( sprintf( 'Could not resolve file path for attachment ID: %d', $attachment_id ) );
        }

        if ( ! file_exists( $file_path ) ) {
            throw new Exception( sprintf( 'File does not exist at path: %s', $file_path ) );
        }

        if ( pathinfo( $file_path, PATHINFO_EXTENSION ) !== 'pdf' ) {
            // Log info about skipping non-PDF file
            $logger->info(
                sprintf('Skipping non-PDF file: %s', $file_path),
                array(
                    'source'     => 'pdf-protect',
                    'order_id'   => $order_id,
                    'product_id' => $product_id,
                    'user_id'    => $user_id
                )
            );
            return; // Let WooCommerce handle non-PDF files
        }

        // Serve DRM-protected file dynamically
        serve_protected_pdf( $file_path, $order );

        // Log success
        $logger->info(
            sprintf('Served protected PDF to User ID: %d', $user_id),
            array(
                'source'     => 'pdf-protect',
                'order_id'   => $order_id,
                'product_id' => $product_id,
                'user_id'    => $user_id
            )
        );

        exit; // Prevent default WooCommerce handling
        
    } catch ( Exception $e ) {
        // Log the error using WC_Logger
        $logger->error(
            sprintf(
                'Failed to serve protected PDF: %s',
                $e->getMessage()
            ),
            array(
                'source'     => 'pdf-protect',
                'order_id'   => $order_id,
                'product_id' => $product_id,
                'user_id'    => $user_id,
                'user_email' => $user_email,
                'backtrace'  => true
            )
        );
        
        // Show user-friendly error message
        wp_die(
            'Ospravedlňujeme sa, pri spracovaní požiadavku na stiahnutie došlo k chybe. Kontaktovali sme podporu, ktorá sa Vám v čo najkratšom čase ozve.',
            'Chyba :(',
            array( 'response' => 404 )
        );
    }
}
