<?php
/*
 * Plugin Name: []VidYen Video Poker
 * Plugin URI: http://vidyen.com
 * Description: A video poker game for the VidYen Point System.
 * Author: VidYen, LLC
 * Version: 0.0.26
 * Author URI: http://VidYen.com
 * Text Domain: vidyen-video-poker
 * License: GPLv2
 * Domain Path: /languages/
*/

include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/shortcodes/videopoker/poker_WP.php'); //SBFG_WP_get_poker_init
include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/shortcodes/vidyen-video-poker-shortcode.php'); //Shortcode Init
include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/functions/vyps-poker-balance-func.php'); //Shortcode Init
include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/functions/vyps-ajax-deduct.php'); //Add ajax
include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/functions/vyps-ajax-add.php'); //deduct ajax

function register_all_setings()
{
	global $VidYen_Video_Poker_Options_str;

  //Video Poker Options	START
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_api_key');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_maximum_bet');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_minimum_initial_bonus');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_maximum_initial_bonus');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_bonuses_before_deposit');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_wins_before_withdraw');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_maximum_deposit');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_minimum_deposit');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_balance_page_leave_confirm');
	register_setting( $VidYen_Video_Poker_Options_str, 'sfbg_sf_videopoker_stop_if_adblock');
  //Video Poker Options	END
}//register_all_setings()

register_activation_hook(__FILE__, 'videyen_video_poker_sql_install');

//Install the SQL tables for VYPS.
function videyen_video_poker_sql_install() {

    global $wpdb;

		//I have no clue why this is needed. I should learn, but I wasn't the original author. -Felty
		$charset_collate = $wpdb->get_charset_collate();

		//NOTE: I have the mind to make mediumint to int, but I wonder if you get 8 million log transactios that you should consider another solution than VYPS.

		//videyen_video_poker table creation
    $table_name_poker = $wpdb->prefix . 'videyen_video_poker';

    $sql = "CREATE TABLE {$table_name_poker} (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		point_id mediumint(9) NOT NULL,
		maximum_bet mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
        ) {$charset_collate};";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php'); //I never did investigate why the original outsource dev used this.

    dbDelta($sql);

		//Default data
		$data_insert = [
				'point_id' => 1,
				'maximum_bet' => 1000,
		];

		$wpdb->insert($table_name_poker, $data_insert);
}

//adding menues
add_action('admin_menu', 'vidyen_video_poker_menu');

function vidyen_video_poker_menu()
{
    $parent_page_title = "VidYen Video Poker";
    $parent_menu_title = 'VY Video Poker';
    $capability = 'manage_options';
    $parent_menu_slug = 'vidyen_video_poker';
    $parent_function = 'vidyen_video_poker_menu_page';
    add_menu_page($parent_page_title, $parent_menu_title, $capability, $parent_menu_slug, $parent_function);
}

//The actual menu
function vidyen_video_poker_menu_page()
{
	global $wpdb;

	if (isset($_POST['point_id']))
	{
		//ID Text value
		$point_id = intval($_POST['point_id']); //Even though I am in the believe if an admin sql injects himself, we got bigger issues, but this has been sanitized.

		//The icon. I'm suprised this works so well
		$max_bet =intval($_POST['max_bet']);

    $table_name_poker = $wpdb->prefix . 'videyen_video_poker';

	    $data = [
	        'point_id' => $point_id,
	        'maximum_bet' => $max_bet,
	    ];

			$wpdb->update($table_name_poker, $data, ['id' => 1]);
	    //$data_id = $wpdb->update($table_name_poker , $data);

	    //I forget thow this works
	    $message = "Added successfully.";
	}

	//the $wpdb stuff to find what the current name and icons are
	$table_name_poker = $wpdb->prefix . 'videyen_video_poker';

	$first_row = 1; //Note sure why I'm setting this.

	//Point_id pull
	$point_id_query = "SELECT point_id FROM ". $table_name_poker . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$point_id_query_prepared = $wpdb->prepare( $point_id_query, $first_row );
	$point_id = $wpdb->get_var( $point_id_query_prepared );

	//Point_id pull
	$max_bet_query = "SELECT maximum_bet FROM ". $table_name_poker . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$max_bet_query_prepared = $wpdb->prepare( $max_bet_query, $first_row );
	$max_bet = $wpdb->get_var( $max_bet_query_prepared );


	//Just setting to 1 if nothing else I suppose, but should always be something
	if ($point_id == '')
	{
		$point_id = 1;
	}

	//Just setting to 1 if nothing else I suppose, but should always be something
	if ($max_bet == '')
	{
		$max_bet = 1000;
	}

	//It's possible we don't use the VYPS logo since no points.
  $vyps_logo_url = plugins_url( 'includes/images/logo.png', __FILE__ );
	//Logo from base. If a plugin is installed not on the menu they can't see it not showing.
	echo '<br><br><img src="' . $vyps_logo_url . '" > ';

	//Static text for the base plugin
	echo
	'<h1>VidYen Video Poker Sub-Plugin</h1>
	<p>The Video poker!</p>
	<table>
		<form method="post">
			<tr>
				<th>Point ID</th>
				<th>Max Bet</th>
				<th>Submit</th>
			</tr>
			<tr>
				<td><input type="number" name="point_id" type="number" id="point_id" min="1" step="1" value="' . $point_id .  '" required="true"></td>
				<td><input type="number" name="max_bet" type="number" id="max_bet" min="1" max="1000000" step="1" value="' . $max_bet . '" required="true"></td>
				<td><input type="submit" value="Submit"></td>
			</tr>
		</form>
	</table>
	';
}
