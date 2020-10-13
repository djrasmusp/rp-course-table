<?php

/**
 * Plugin Name: RP Course Table
 * Version: 1.0.0
 * Plugin URI: https://rasmusp.com
 * Description: Technical test for Erhvervshjemmesider.dk
 * Requires at leat: 5.0
 * Tested up to: 5.5.1
 * License: GLPv2 or later
 * Text-domain: course-table
 */

defined( 'ABSPATH' ) or exit();

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require 'vendor/autoload.php';
}

use Course_Table\Base\Activate;
use Course_Table\Base\Deactive;

register_activation_hook( __FILE__, function () {
	Activate::activate();
} );

register_deactivation_hook( __FILE__, function () {
	Deactive::deactivate();
} );

if ( class_exists( 'Course_Table\\Init' ) ) {
	Course_Table\Init::register_services();
}


