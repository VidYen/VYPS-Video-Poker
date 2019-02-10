<?php
/*
 * Plugin Name: []VidYen Video Poker
 * Plugin URI: http://vidyen.com
 * Description: A video poker game for the VidYen Point System.
 * Author: VidYen, LLC
 * Version: 0.0.23
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
    $table_name_points = $wpdb->prefix . 'videyen_video_poker';

    $sql = "CREATE TABLE {$table_name_points} (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		point_id mediumint(9) NOT NULL,
		maximum_bet mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
        ) {$charset_collate};";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php'); //I never did investigate why the original outsource dev used this.

    dbDelta($sql);
}
