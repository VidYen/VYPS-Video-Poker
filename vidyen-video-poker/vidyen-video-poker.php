<?php
/*
 * Plugin Name: VidYen Video Poker
 * Plugin URI: http://vidyen.com
 * Description: A video poker game for the VidYen Point System.
 * Author: VidYen, LLC
 * Version: 0.0.1
 * Author URI: http://VidYen.com
 * Text Domain: vidyen-video-poker
 * License: GPLv2
 * Domain Path: /languages/
*/

include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_WP.php'); //SBFG_WP_get_poker_init
include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'includes/shortcodes/vidyen-video-poker.php'); //Shortcode Init


$VidYen_Video_Poker_Options_str = 'SBFO';

function VidYen_Video_Poker_load_plugin_textdomain() {
    load_plugin_textdomain( 'vidyen-video-poker', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'VidYen_Video_Poker_load_plugin_textdomain' );


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


function admin_menu()
{
	$this->register_all_setings();
	add_options_page( __( 'Simple Bitcoin Faucets', 'vidyen-video-poker' ), __( 'Simple Bitcoin Faucets', 'vidyen-video-poker' ), 'manage_options', 'vidyen-video-poker', array( $this, 'render_options' ) );
}

function render_options()
{
	require_once(dirname(__FILE__).'/sbf_admin.php');
}

function add_settings_link( $links )
{
	$img = '<img style="vertical-align: middle;width:24px;height:24px;border:0;" src="'. plugin_dir_url( __FILE__ ) . 'sbf_lib/bitcoin_64.png'.'"></img>';
	$settings_link = '<a href="' . admin_url('/options-general.php?page=vidyen-video-poker') . '">' . $img . __( 'Settings' ) . '</a>';
	array_unshift($links , $settings_link);
	return $links;
}

$GLOBALS['VidYen_Video_Poker_Plugin'] = new VidYen_Video_Poker_Plugin;
