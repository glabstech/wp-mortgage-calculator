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

    //front-end js
    \add_action('wp_enqueue_scripts', [&$instance, 'FEEnqueue']);
  }

  /**
   * Enqueu Admin scripts in the front-end
   */
  public function FEEnqueue(){

    //handle bar
    \wp_register_script( 'wpmc-handlebar-js', \plugin_dir_url( WPMCALC_PLUGIN )."lib/handlebars.js", [], WPMCALC_VERSION );
    \wp_enqueue_script( "wpmc-handlebar-js", \plugin_dir_url( WPMCALC_PLUGIN )."lib/handlebars.js", [], WPMCALC_VERSION ); 
    // END :: handle bar 

    //Popper and Tippy
    \wp_enqueue_script( 'wpmc-poppy-js', \plugin_dir_url( WPMCALC_PLUGIN )."lib/popper.js", [], WPMCALC_VERSION );
    \wp_enqueue_script( 'wpmc-tippy-js', \plugin_dir_url( WPMCALC_PLUGIN )."lib/tippy.js", [], WPMCALC_VERSION );


    //main script
    \wp_register_script( 
      'wpmc-main-js', 
      \plugin_dir_url( WPMCALC_PLUGIN )."assets/public/js/wpmc-functions.js",
      [],
      WPMCALC_VERSION
    );

    \wp_enqueue_script(
      "wpmc-main-js",
      \plugin_dir_url( WPMCALC_PLUGIN )."assets/public/js/wpmc-functions.js",
      [],
      WPMCALC_VERSION
    ); 

    // Localize the script with new data
   $wpmcMainScript = json_decode( carbon_get_theme_option('crb_variables_object') );
   \wp_localize_script( 'wpmc-main-js', 'WPMC', $wpmcMainScript );


    // END :: handle bar 

    \wp_enqueue_style( 'wpmc-main-css', \plugin_dir_url( WPMCALC_PLUGIN )."assets/public/css/wpmc-style.css", [], WPMCALC_VERSION );

  }

  /**
   * Enqueue Admin scripts and styling
   */
  public function adminEnqueue(){

    // CodeMirror
    \wp_enqueue_style( 'wpmc-codemirror-css', \plugin_dir_url( WPMCALC_PLUGIN )."lib/codemirror/lib/codemirror.css", [], WPMCALC_VERSION );
    \wp_enqueue_script( 'wpmc-codemirror-js', \plugin_dir_url( WPMCALC_PLUGIN )."lib/codemirror/lib/codemirror.js", [], WPMCALC_VERSION );
    \wp_enqueue_script( "wpmc-codemirror-addon-overlay", \plugin_dir_url( WPMCALC_PLUGIN )."lib/codemirror/addon/mode/overlay.js", [], WPMCALC_VERSION ); 
    \wp_enqueue_script( "wpmc-codemirror-mode-xml", \plugin_dir_url( WPMCALC_PLUGIN )."lib/codemirror/mode/xml/xml.js", [], WPMCALC_VERSION ); 
    // END :: CodeMirror

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