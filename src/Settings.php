<?php 

namespace WPMortgageCalculator;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Settings {

  private static $instance;
    
  private $plugin;


  private function __construct() {
      $this->plugin = \WPMortgageCalculator\Plugin::instance();
  }
  

  public static function instance()
  {
      if (!self::$instance) {
          self::$instance = new self();
      }
      
      return self::$instance;
  }

  public static function init() {
    $instance = self::instance();

    //admin js
    \add_action('admin_enqueue_scripts', [&$instance, 'adminEnqueue']);
  }

  /**
   * Enqueue Admin scripts and styling
   */
  public function adminEnqueue(){

    //JSON Editor 
    \wp_register_script( 
      'JSONEditor', 
      \plugin_dir_url( WPMCALC_PLUGIN )."lib/jsoneditor.min.js",
      [],
      WPMCALC_VERSION
    );

    \wp_enqueue_script(
      "JSONEditor",
      \plugin_dir_url( WPMCALC_PLUGIN )."lib/jsoneditor.min.js",
      [],
      WPMCALC_VERSION
    ); 
    // END :: JSON Editor 

    //Font Awesome
    \wp_enqueue_style(
      'font-awesome',
      \plugin_dir_url( WPMCALC_PLUGIN )."lib/font-awesome-4/css/font-awesome.min.css",
      [],
      WPMCALC_VERSION
    );


    //Main Admin Script 
    \wp_register_script( 
      'wpmc-admin-script', 
      \plugin_dir_url( WPMCALC_PLUGIN )."assets/admin/js/wpmc-admin.js",
      [],
      WPMCALC_VERSION
    );

    \wp_enqueue_script(
      "wpmc-admin-script",
      \plugin_dir_url( WPMCALC_PLUGIN )."assets/admin/js/wpmc-admin.js",
      [],
      WPMCALC_VERSION
    ); 
    // END :: Main Admin Script

    //Main Admin css
    \wp_enqueue_style(
      'wpmc-admin-css',
      \plugin_dir_url( WPMCALC_PLUGIN )."assets/admin/css/wpmc-admin.css",
      [],
      WPMCALC_VERSION
    );


  }

}