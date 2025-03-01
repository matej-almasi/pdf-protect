<?php
/*
Plugin Name: PDF Data Rights Protect
Description: Embeds a data rights notice with customer details as the second page of a served pdf digital product.
Version: 0.1.0
Author: Matej Almáši
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Ensure Composer's autoloader is included
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Include main functionality file
require_once plugin_dir_path( __FILE__ ) . 'includes/pdf-protect.php';