<?php
/**
 * Transcribe
 *
 * @package       TRANSCRIBE
 * @author        ed
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Transcribe
 * Plugin URI:    https://mydomain.com
 * Description:   This is some demo short description...
 * Version:       1.0.0
 * Author:        ed
 * Author URI:    https://your-author-domain.com
 * Text Domain:   transcribe
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'TRANSCRIBE_NAME',			'Transcribe' );

// Plugin version
define( 'TRANSCRIBE_VERSION',		'1.0.0' );

// Plugin Root File
define( 'TRANSCRIBE_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'TRANSCRIBE_PLUGIN_BASE',	plugin_basename( TRANSCRIBE_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'TRANSCRIBE_PLUGIN_DIR',	plugin_dir_path( TRANSCRIBE_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'TRANSCRIBE_PLUGIN_URL',	plugin_dir_url( TRANSCRIBE_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once TRANSCRIBE_PLUGIN_DIR . 'core/class-transcribe.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  ed
 * @since   1.0.0
 * @return  object|Transcribe
 */
function TRANSCRIBE() {
	return Transcribe::instance();
}

TRANSCRIBE();
