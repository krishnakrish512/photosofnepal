<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://lakshman.com.np
 * @since             1.0.0
 * @package           Next_Gen_Image
 *
 * @wordpress-plugin
 * Plugin Name:       Next-Gen Image format for developer
 * Plugin URI:        http://lakshman.com.np
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Laxman Thapa
 * Author URI:        http://lakshman.com.np
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       next-gen-image
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require __DIR__.'/bootstrap.php';


