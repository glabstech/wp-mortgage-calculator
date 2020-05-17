<?php 

namespace WPMortgageCalculator;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Plugin {

  const VERSION = "1.0.0";

  private $config;

  private static $instance;

  private $settings = null;
  

  private function __construct() {
    $this->config = array();
  }
  

  public static function instance() {
      if( !self::$instance ) {
          self::$instance = new Plugin();
          self::$instance->loadTextdomain();
          self::$instance->hooks();
          self::$instance->loadAdminOptions();
          self::$instance->initSettings();
      }

      return self::$instance;
  }

  
  public static function load() {
    return Plugin::instance();
  } 


  public function loadTextdomain() {
    \load_plugin_textdomain( 'wpmc', false, dirname( \plugin_basename( __FILE__  ) ) . '/languages/' );
  }


  public function configure(array $config) {
    $this->config = array_merge($this->config, $config);
  }


  private function hooks() {
    //\add_action('wp_head', array(&$this, 'initJsLogging'));
    //\add_action('admin_head', array(&$this, 'initJsLogging'));

    \register_activation_hook( __FILE__, array($this, 'activate_wpmc') );
    \register_deactivation_hook( __FILE__, array($this, 'deactivate_wpmc') );

    \add_filter('setup_theme',function(){
      \Carbon_Fields\Carbon_Fields::boot();
    });

  }


  private function initSettings() {
    Settings::init();
  }

  
  private function loadAdminOptions(){
    AdminOptions::init();
  }

   
  private function activate_wpmc(){
    global $wp_rewrite; 
		$wp_rewrite->flush_rules( true );
  }


  private function deactivate_wpmc(){
    //TODO
  }


}