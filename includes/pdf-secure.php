<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_filter( 'woocommerce_email_customer_details', 'remove_download_links_from_email', 10, 3 );

function remove_download_links_from_email( $order, $sent_to_admin, $plain_text ) {
    if ( $order->has_downloadable_item() ) {
        // Add logic here to modify or remove download-related sections
        remove_action( 'woocommerce_order_item_meta_end', 'woocommerce_email_downloads', 10 );
    }
}

add_filter( 'woocommerce_order_get_downloadable_items', 'customize_downloadable_links', 10, 2 );

function customize_downloadable_links( $downloads, $order ) {
    foreach ( $downloads as $download_id => $download ) {
        // Customize the download URL
        $custom_url = generate_custom_download_link( $download['file'], $order );

        // Replace the original download link
        $downloads[ $download_id ]['download_url'] = $custom_url;
    }

    return $downloads;
}
