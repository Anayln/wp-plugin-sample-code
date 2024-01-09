<?php

/**
 *
 * @link              https://digitalpie.co.nz
 * @since             1.0.0
 * @package           Vet_Pharmacy_Prescriptions
 *
 * @wordpress-plugin
 * Plugin Name:       Vet Pharmacy Prescriptions
 * Plugin URI:        https://digitalpie.co.nz
 * Description:       A module to handle Veterinary Prescriptions and orders for restricted medicines in WooCommerce.
 * Version:           1.0.0
 * Author:            Digital Pie
 * Author URI:        https://digitalpie.co.nz/
 * License:           Copyright Digital Pie Limited (NZ). Licenced to 'Vet Post Limited (NZ)' only. Unauthorised use will be detected and prosecuted.
 * Text Domain:       vet-pharmacy-prescriptions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VET_PHARMACY_PRESCRIPTIONS_VERSION', '1.0.0' );
define( 'VET_PHARMACY_PRESCRIPTIONS_TEXTDOMAIN', 'vet-pharmacy-prescriptions' );
define( 'VET_PHARMACY_PRESCRIPTIONS_FILE', __FILE__ );
define( 'VET_PHARMACY_PRESCRIPTIONS_URL', plugin_dir_url(VET_PHARMACY_PRESCRIPTIONS_FILE) );
define( 'VET_PHARMACY_PRESCRIPTIONS_ABSPATH', dirname(VET_PHARMACY_PRESCRIPTIONS_FILE));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vet-pharmacy-prescriptions-activator.php
 */
function activate_vet_pharmacy_prescriptions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vet-pharmacy-prescriptions-activator.php';
	Vet_Pharmacy_Prescriptions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vet-pharmacy-prescriptions-deactivator.php
 */
function deactivate_vet_pharmacy_prescriptions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vet-pharmacy-prescriptions-deactivator.php';
	Vet_Pharmacy_Prescriptions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vet_pharmacy_prescriptions' );
register_deactivation_hook( __FILE__, 'deactivate_vet_pharmacy_prescriptions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vet-pharmacy-prescriptions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vet_pharmacy_prescriptions() {

	$plugin = new Vet_Pharmacy_Prescriptions();
	$plugin->run();

}
run_vet_pharmacy_prescriptions();