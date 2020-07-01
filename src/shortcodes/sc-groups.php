<?php 

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


function wpmc_groups_func( $atts ) {
	$a = shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
  ), $atts );
  
  $template = carbon_get_theme_option('crb_template');
  ob_start();
  ?>
    <script id="wpmc-groups" type="text/x-handlebars-template">
    <?php echo $template ?>
    </script>
    <div class="wpmc-groups"></div>
  <?php

	return ob_get_clean();
}
add_shortcode( 'wpmc-groups', 'wpmc_groups_func' );