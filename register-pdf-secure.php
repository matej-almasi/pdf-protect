<?php
/*
Plugin Name: PDF Data Rights Embed
Description: This is my first plugin! It makes a new admin menu link!
Version: 0.1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Include main functionality file
require_once plugin_dir_path( __FILE__ ) . 'includes/pdf-secure.php';