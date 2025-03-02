<?php
/**
* Plugin Name: PDF Protect
* Plugin URI: https://github.com/matej-almasi/pdf-protect
* Description: Embeds a data rights notice with customer details as the second page of a served pdf digital product.
* Version: 1.0.0
* Author: Matej Almáši
* Author URI: https://github.com/matej-almasi
* License: GNU General Public License v3.0
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Ensure Composer's autoloader is included
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Include main functionality file
if ( file_exists( __DIR__ . '/includes/pdf-protect.php' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/pdf-protect.php';
}