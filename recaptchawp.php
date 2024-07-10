<?php
/**
 * Recaptchawp Plugin
 *
 * @package     Isaidi\Recaptchawp
 * @author      isaidi
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Recaptchawp
 * Plugin URI:  https://github.com/ibronos/recaptchawp
 * Description: WordPress login recaptcha plugin.
 * Version:     1.0.0
 * Author:      isaidi
 * Author URI:  https://isaidi.vercel.app
 * Text Domain: Captcha Plugin
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function autoload_files() {

	// add the list of files to load here.
	$files = array(
		'admin/settings.php'
	);

	foreach ( $files as $file ) {
		require __DIR__ . '/src/' . $file;
	}
}

function launch() {
	autoload_files();
}

launch();