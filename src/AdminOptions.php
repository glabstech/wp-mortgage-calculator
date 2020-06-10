<?php 

namespace WPMortgageCalculator;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class AdminOptions {

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

    \add_action( 'carbon_fields_register_fields', function(){
    
      /**
        * MAIN CONTAINER in Options
      */

      $plugin_options = Container::make( 'theme_options', 'WPMC Options');

      /**
       * Variables and Constants
       */
      $plugin_options->add_tab(
        __('Variables and Constants'),
        [
          Field::make( 'textarea', 'crb_variables_object', __( '' ) )
            ->set_classes( 'wpmc_variable_object' )
            //          Field::make( 'rich_text', 'crb_variables_object', __( 'Configuration Object (JSON)' ) )
          //->set_classes( 'wpmc_variable_object' )
        ]
      );

      /**
       * Email
       */
      $plugin_options->add_tab(
        __('Email'),
        [
          Field::make( 'text', 'crb_admin', __( 'Admin Email' ) )
        ]
      );

    });
  }


}