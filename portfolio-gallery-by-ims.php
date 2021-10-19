<?php

/**
 *
 * @link       http://acewebx.com
 * @since      1.0.5
 * @package    ims-portfolio
 * @subpackage ims-portfolio/includes
 *
 * @wordpress-plugin
 * Plugin Name:       Portfolio Gallery Plugin
 * Plugin URI:        http://acewebx.com/ims-portfolio-gallery
 * Description:       This plugin will help you to display your portfolio with categories wise without page refresh, also it gave you the option to provide the detailed discription about your project/protfolio including tag features. Shortcode [ims-portfolio]
 * Version:           1.0.5
 * Author:            AceWebx Team
 * Author URI:        http://acewebx.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ims-portfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IMS_PORTFOLIO_VERSION', '1.0.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ims-portfolio-activator.php
 */
function activate_ims_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ims-portfolio-activator.php';
    Ims_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ims-portfolio-deactivator.php
 */
function deactivate_ims_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ims-portfolio-deactivator.php';
	Ims_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ims_portfolio' );
register_deactivation_hook( __FILE__, 'deactivate_ims_portfolio' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ims-portfolio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ims_portfolio() {

	$plugin = new Ims_Portfolio();
	$plugin->run();

}
run_ims_portfolio();
