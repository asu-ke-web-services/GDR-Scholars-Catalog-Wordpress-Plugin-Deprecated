<?php
/**
 * GDR Scholars Catalog
 *
 *
 * @package   gdrscholars-catalog
 * @author    Nathan Rollins
 * @license   GPL-3.0
 * @link      https://sustainability.asu.edu
 * @copyright 2017 Julie Ann Wrigley Global Institute of Sustainability
 *
 * @wordpress-plugin
 * Plugin Name:       GDR-Scholars-Catalog
 * Plugin URI:        https://sustainability.asu.edu
 * Description:       WP plugin to deploy the ReactJS application for the GDR Catalog
 * Version:           0.1.1
 * Author:            Julie Ann Wrigley Global Institute of Sustainability
 * Author URI:        https://sustainability.asu.edu
 * Text Domain:       gdrscholars-catalog
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'GDR_CATALOG_VERSION', '0.1.1' );


require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wpr.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wpr-shortcode.php' );
// require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wpr-admin.php' );
// require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wpr-rest-controller.php' );

/**
 * Initialize Plugin
 *
 * @since 0.8.0
 */
function gdr_catalog_init() {
	$wpr = WPReactivate::get_instance();
	$wpr_shortcode = WPReactivate_Shortcode::get_instance();
	// $wpr_admin = WPReactivate_Admin::get_instance();
	// $wpr_rest = WPReactivate_REST_Controller::get_instance();
}
add_action( 'plugins_loaded', 'gdr_catalog_init' );

/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, array( 'WPReactivate', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WPReactivate', 'deactivate' ) );

