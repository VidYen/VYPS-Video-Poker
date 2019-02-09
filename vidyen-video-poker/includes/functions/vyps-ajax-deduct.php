<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*** PHP Functions to handle AJAX request***/

// register the ajax action for authenticated users
add_action('wp_ajax_vyps_run_deduct_action', 'vyps_run_deduct_action');

// handle the ajax request
function vyps_run_deduct_action()
{
  global $wpdb; // this is how you get access to the database

  $bet_cost = intval( $_POST['bet_amount'] );

  $incoming_pointid_get = 3; //Hard coded for now

  // Shortcode additions.
  $atts = shortcode_atts(
    array(
        'outputid' => $incoming_pointid_get,
        'outputamount' => 1,
        'refer' => 0,
        'to_user_id' => get_current_user_id(),
        'comment' => '',
        'reason' => 'QUADBET',
        'btn_name' => 'QUADRUN',
        'raw' => TRUE,
        'cost' => 1,
        'pid' => $incoming_pointid_get,
        'firstid' => $incoming_pointid_get,
        'firstamount' => $bet_cost,
    ), $atts, 'vyps-pe' );

  //Deduct. I figure there is a check when need to run.
  $deduct_results = vyps_deduct_func( $atts );

  echo json_encode($deduct_results);

  wp_die(); // this is required to terminate immediately and return a proper response
}
