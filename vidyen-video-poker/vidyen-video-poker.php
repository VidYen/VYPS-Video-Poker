<?php
/*
 * Plugin Name: []VidYen Video Poker
 * Plugin URI: http://vidyen.com
 * Description: A video poker game for the VidYen Point System.
 * Author: VidYen, LLC
 * Version: 0.0.20
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

//$GLOBALS['VidYen_Video_Poker_Plugin'] = new VidYen_Video_Poker_Plugin;
