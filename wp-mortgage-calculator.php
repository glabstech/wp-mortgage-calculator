<?php
/**
 * Plugin Name:     WP Mortgage Calculator
 * Plugin URI:      https://wordpress.org/plugins/wp-mortgage-calculator
 * Description:     A Dynamic Mortgage Calculator
 * Version:         1.0.3
 * Author:          Glabs Tech
 * Author URI:      https://glabs.tech/wp-mortgage-calculator
 * Text Domain:     wpmc
 * Tested up to:    5.4.1
 *
 * @package         WPMortgageCalculator
 * @author          wdonayre
 * @copyright       wdonayre
 */
 
namespace WPMortgageCalculator;

use WPMortgageCalculator\scGroups;

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


define( 'WPMCALC_VERSION', '1.0.3' );

define( 'WPMCALC_REQUIRED_WP_VERSION', '4.2' );

define( 'WPMCALC_PLUGIN', __FILE__ );

define( 'WPMCALC_PLUGIN_BASENAME', plugin_basename( WPMCALC_PLUGIN ) );

define( 'WPMCALC_PLUGIN_NAME', trim( dirname( WPMCALC_PLUGIN_BASENAME ), '/' ) );

define( 'WPMCALC_PLUGIN_DIR', untrailingslashit( dirname( WPMCALC_PLUGIN ) ) );

define( 'WPMCALC_PLUGIN_MODULES_DIR', WPMCALC_PLUGIN_DIR . '/modules' );

define( 'WPMCALC_GITHUB_USER', 'glabstech');

if( !class_exists('WPMortgageCalculator') ) {
    require_once \plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
}

require_once 'src/shortcodes/shortcodes.php';

\WPMortgageCalculator\Plugin::load();