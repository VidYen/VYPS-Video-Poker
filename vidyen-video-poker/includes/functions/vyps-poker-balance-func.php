<?php

/*
*	Balance shortcode revision.
*	I realized that I should give more power to the admins in their flexibility
*	so made shortcodes to call specific pointIDs and user IDs.
*	Scrapping the old code as it was terrible.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function vidyen_poker_balance_func($atts)
{
	global $wpdb; //Seeing if this needs to be moved up

	//Make sure user is logged in.

	if ( ! is_user_logged_in())
	{
		return 0;
	}

	$atts = shortcode_atts(
		array(
				'pid' => '0',
				'uid' => '0',
				'raw' => TRUE,
				'decimal' => 0,
		), $atts, 'vyps-balance' );

	$pointID = $atts['pid'];
	$userID = $atts['uid'];
	//$isRaw = $atts['raw'];
	$decimal_format_modifier = intval($atts['decimal']); //This has to be a int or will throw the number format

	//Ok if admin set an UID, they can override current user to see anyone
	//I realize in theory you could do this with WW as well.
	//Raw is for if you want just the number. Otherwise it comes with the icon and commas. Perhaps I should break this off into a 3rd way.
	//But its possible for admin to set to no if they want

	if ( $userID == 0 )
	{
		$userID = get_current_user_id();
	}

	if ( $pointID == 0 )
	{
		return 0;
	}
	
	//Now for the balances.
	$table_name_log = $wpdb->prefix . 'vyps_points_log';
	$table_name_points = $wpdb->prefix . 'vyps_points';

	$sourcePointID = $pointID; //reuse of code //I do not mind $pointID being called $sourcePointID rather than the current versus userID semantic.

	//name and icon

	//$sourceName = $wpdb->get_var( "SELECT name FROM $table_vyps_points WHERE id= '$sourcePointID'" );
	$sourceName_query = "SELECT name FROM ". $table_name_points . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
  $sourceName_query_prepared = $wpdb->prepare( $sourceName_query, $sourcePointID );
  $sourceName = $wpdb->get_var( $sourceName_query_prepared );

	//$sourceIcon = $wpdb->get_var( "SELECT icon FROM $table_vyps_points WHERE id= '$sourcePointID'" );
	$sourceIcon_query = "SELECT icon FROM ". $table_name_points . " WHERE id= %d";
	$sourceIcon_query_prepared = $wpdb->prepare( $sourceIcon_query, $sourcePointID );
	$sourceIcon = $wpdb->get_var( $sourceIcon_query_prepared );

	//balance
	//$balance_points = $wpdb->get_var( "SELECT sum(points_amount) FROM $table_vyps_log WHERE user_id = $userID AND points = $pointID"); //Oooh. I love it when I get my variable names the same.
	$balance_points_query = "SELECT sum(points_amount) FROM ". $table_name_log . " WHERE user_id = %d AND point_id = %d";
	$balance_points_query_prepared = $wpdb->prepare( $balance_points_query, $userID, $sourcePointID ); //NOTE: Originally this said $current_user_id but although I could pass it through to something else it would not be true if admin specified a UID. Ergo it should just say it $userID
	$balance_points = $wpdb->get_var( $balance_points_query_prepared );

	if ($balance_points == '')
	{

		//Just a quick check to see if there were not points that it at least shows zero.
		$balance_points = 0;

	}

	$balance_output = intval($balance_points); //Just the raw data please. No formatting. NOTE: Youy will have to call for it if you use this function. Hrm... Maybe that should be at top.

	$_SESSION["cm_balance"] = $balance_output;

	//Out it goes!
	return $balance_output;

}

add_shortcode('vidyen-video-poker-balance', 'vidyen_poker_balance_func');
