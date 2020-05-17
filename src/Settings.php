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
  }


}