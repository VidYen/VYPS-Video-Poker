<?php
/*
 * Plugin Name: VidYen Video Poker
 * Plugin URI: http://vidyen.com
 * Description: A video poker game for the VidYen Point System.
 * Author: VidYen, LLC
 * Version: 1.1.0
 * Author URI: http://VidYen.com
 * Text Domain: vidyen-video-poker
 * License: GPLv2
 * Domain Path: /languages/
*/

include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_WP.php'); //SBFG_WP_get_poker_init


$Simple_Bitcoin_Faucets_Options_str = 'SBFO';

function Simple_Bitcoin_Faucets_load_plugin_textdomain() {
    load_plugin_textdomain( 'vidyen-video-poker', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'Simple_Bitcoin_Faucets_load_plugin_textdomain' );



class VidYen_Video_Poker_Plugin {
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'wp_head', array( $this, 'insert_rewarder' ) );

		add_action( 'user_register', array( $this, 'user_registered' ) ); //referral
		add_action( 'wp_login', array( $this, 'user_login' ) , 10, 2); //referral

		add_filter( "plugin_action_links_" . plugin_basename(  __FILE__ ), array( $this,'add_settings_link') );
		add_shortcode('SBFR', array( $this, 'reward_shortcode') );
		add_shortcode('SBFG_VIDEOPOKER', array( $this, 'videopoker_shortcode') );
		add_shortcode('SBFG_BUBBLESHOOTER', array( $this, 'bubbleshooter_shortcode') );

//		add_filter( 'after_setup_theme', 'programmatically_create_post' );
	}

	function insert_rewarder( )
	{
		if(get_option('sfbr_include_all_pages') == 'on')
		{
			echo($this->reward_shortcode( 0 ));
		}
	}

	function main_js_shortcode_localize()
	{
		$ret = '';
		$ret .= "\n var sfbg_main_ready = '".__('Ready for the prize?','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_no = '".__('No thanks','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_yes = '".__('Yes please!','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_score = '".__('Score','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_confirm = '".__('Are you sure','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_delete = '".__('Delete','vidyen-video-poker') ."';";
		$ret .= "\n var sfbg_main_add = '".__('Add','vidyen-video-poker') ."';";
		return($ret);
	}


  function videopoker_shortcode_top()
  {
    $ret = '';

    $ret .= "\n<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css'>";
    $ret .= "\n<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>";
    $ret .= "\n<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>";

    //do it once, do it here so can be defined in standalone version, poker_util.php
    if(!function_exists ( 'poker_get_main_url' ))
    {
      function poker_get_main_url() //
      {
        return(plugin_dir_url( __FILE__ ).'videopoker/');
      }
    }

    include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_get_settings.php');
    include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_util.php');
    $ret .= settings_to_js();
    if($stop_if_adblock)
      $ret .= "\n<script src='" . plugin_dir_url( __FILE__ ) . "videopoker/lib/advertisment.js'></script>\n";
    include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_lang_WP.php');
    $ret .= poker_text_to_js();

    $ret .= "\n<link href='" . plugin_dir_url( __FILE__ ) . "videopoker/lib/messagebox.css' rel='stylesheet'>";
    $ret .= "\n<script src='" . plugin_dir_url( __FILE__ ) . "videopoker/lib/messagebox.js'></script>";
    $ret .= "\n<link href='" . plugin_dir_url( __FILE__ ) . "videopoker/poker.css' rel='stylesheet'>";
    $ret .= "\n<script src='" . plugin_dir_url( __FILE__ ) . "videopoker/poker.js'></script>	";
    $ret .= "\n<script src='" . plugin_dir_url( __FILE__ ) . "videopoker/poker_util.js'></script>";
    return($ret);
  }

  function videopoker_shortcode_body()
  {
    $ret = '';
    $ret .= "\n";
    include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR .  'videopoker/poker_WP.php');
    SBFG_WP_poker_settings_to_session();
    $ret .= SBFG_WP_get_poker_body();
    return($ret);
  }

  function videopoker_shortcode_localize()
  {
    $ret = '';
    return($ret);
  }

  function videopoker_shortcode( $atts )
  {
    $ret = '';
    $ret .= $this->videopoker_shortcode_localize();
    $ret .= $this->videopoker_shortcode_top();
    $ret .= $this->videopoker_shortcode_body();
    return($ret);
  }

	function reward_shortcode_localize()
	{
		$ret = '';
		$ret .= "\n RemoteFaucetSurferReward.txt_bonus = '" . __('bonus','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_click_bonus = '" . __('Get your bonus!','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_more_pages = '" . __('Visit %n more pages for the bonus','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_close = '" . __('close','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_info = '" . __('info','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_loading = '" . __('loading','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_shown = '" . __('faucet shown in other window','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_discard_confirm = '" . __('Bonus will be discarded!\n\nAre you sure?','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_thanks_visits = '" . __('<b>Thanks for visiting %n pages!</b>','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_more_seconds = '" . __('%n more seconds to count the page','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_already_visited = '" . __('Already visited!','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_off_now = '" . __('Close for now','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_off_day = '" . __('Off for day','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_off_week = '" . __('Off for week','vidyen-video-poker') ."';";
		$ret .= "\n RemoteFaucetSurferReward.txt_off_month = '" . __('Off for month','vidyen-video-poker') ."';";
		return($ret);
	}




	function reward_shortcode( $atts )
	{
		$ret = '';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "rewarder/wme_rfsr.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "rewarder/wme_rfsr.js'></script>";
		$ret .= "\n <script>";
		$ret .= $this->reward_shortcode_localize();
		$ret .= "\n RemoteFaucetSurferReward.faucet_id = " . get_option('sfbr_faucet_id','123456') . ";" ;
		$ret .= "\n RemoteFaucetSurferReward.box_size = '" . get_option('sfbr_mark_size','40') . "px';" ;
		$ret .= "\n RemoteFaucetSurferReward.allow_reloads = " . get_option('sfbr_allow_reloads','false') . ";" ;
		$ret .= "\n RemoteFaucetSurferReward.allow_repeats = " . get_option('sfbr_allow_repeats','false') . ";" ;
		$ret .= "\n RemoteFaucetSurferReward.pages_to_visit = " . get_option('sfbr_pages_to_visit','10') . ";" ;
		$ret .= "\n RemoteFaucetSurferReward.seconds_on_page = " . get_option('sfbr_seconds_on_page','5') . ";" ;
		$ret .= "\n RemoteFaucetSurferReward.vertical_side = '" . get_option('sfbr_mark_v_position','top') . "';";
		$ret .= "\n RemoteFaucetSurferReward.vertical_offset = '" . get_option('sfbr_mark_v_offset','30') . "px';" ;
		$ret .= "\n RemoteFaucetSurferReward.horizontal_side = '" . get_option('sfbr_mark_h_position','left') . "';";
		$ret .= "\n RemoteFaucetSurferReward.horizontal_offset = '" . get_option('sfbr_mark_h_offset','30') .  "px';" ;
		$ret .= "\n RemoteFaucetSurferReward.faucet_extra_styles='width:500px;';";
		$ret .= "\n </script>";
		return($ret);
	}

	function blockrain_shortcode( $atts )
	{
		$ret = '';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "blockrain/blockrain.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "blockrain/blockrain.jquery.js'></script>";
		$ret .= "\n".'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">';
		$ret .= "\n".'<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.js'></script>";
		$ret .= "\n <div style='display:none' sbf_game_settings='blockrain'>".get_option('sfbg_sf_blockrain','1000:123456,5000:123456,10000:123456,20000:123456,30000:123456,40000:123456,50000:123456,70000:123456')."</div>";
		$ret .= "\n <script>";
		$ret .= $this->blockrain_shortcode_localize();
		$ret .= "\n </script>";
		$ret .= "\n".'<div class="sfbg_br_game_wrap" style="min-width:400px; min-height:500px;"><center>';
		$ret .= "\n".'<div class="sfbg_br_game" style="width:250px; height:500px;"></div>';
		$ret .= "\n".'<div id="sfbg_br_faucet-TO-BE" style="display:none;min-width:400px;min-height:400px;"></div></center></div>';
		$ret .= "\n".'<script src="' . plugin_dir_url( __FILE__ ) . 'blockrain/starter.js"></script>';

		return($ret);
	}

	function g2048_shortcode( $atts )
	{
		$ret = '';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "2048/css/jquery.2048.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "2048/js/jquery.2048.js'></script>";
		$ret .= "\n".'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">';
		$ret .= "\n".'<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.js'></script>";
		$ret .= "\n <div style='display:none' sbf_game_settings='2048'>".get_option('sfbg_sf_2048','64:123456,128:123456,256:123456,512:123456,1024:123456,2048:123456')."</div>";
		$ret .= "\n <script>";
		$ret .= $this->g2048_shortcode_localize();
		$ret .= "\n </script>";
		$ret .= "\n".'<div class="sfbg_2048_game_wrap" style="min-width:300px; min-height:300px;"><center>';
		$ret .= "\n".'<div class="2048container text-center" id="sfbg_2048_game"></div>';
		$ret .= "\n".'<div id="sfbg_2048_faucet-TO-BE" style="display:none;min-width:400px;min-height:400px;"></div></center></div>';
		$ret .= "\n".'<script src="' . plugin_dir_url( __FILE__ ) . '2048/starter.js"></script>';

		return($ret);
	}

	function lines_shortcode( $atts )
	{
		$ret = '';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "lines/lines.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "lines/lines.js'></script>";
		$ret .= "\n".'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">';
		$ret .= "\n".'<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>';
		$ret .= "\n <link rel='stylesheet' href='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.css'>";
		$ret .= "\n <script src='" . plugin_dir_url( __FILE__ ) . "sbf_lib/sbf.js'></script>";
		$ret .= "\n <div style='display:none' sbf_game_settings='lines'>".get_option('sfbg_sf_lines','10:123456,50:123456,150:123456,300:123456,450:123456')."</div>";
		$ret .= "\n <script>";
		$ret .= $this->lines_shortcode_localize();
		$ret .= "\n </script>";
		$ret .= "\n".'<div class="sfbg_ln_game_wrap" style="border:0px dotted gray;">';
		$ret .= "\n".'<div id="sfbg_ln_game" class="sfbg_ln_game" >';
		$ret .= "\n".'	<center><div id="game" style="width:450px">';
		$ret .= "\n".'			<div class="sfbg_ln_score">' . __( 'Score', 'vidyen-video-poker' ) . ' : <strong class="score">0</strong></div>';
		$ret .= "\n".'			<div class="forecast sfbg_ln_forecast"></div>';
		$ret .= "\n".'		<div class="grid"></div>';
		$ret .= "\n".'	</div></center>';
		$ret .= "\n".'</div>';
		$ret .= "\n".'</div>';
		$ret .= "\n".'<div id="sfbg_ln_faucet-TO-BE" style="display:none;min-width:400px;min-height:400px;"></div></div>';
		$ret .= "\n".'<script src="' . plugin_dir_url( __FILE__ ) . 'lines/starter.js"></script>';
		return($ret);
	}


	function check_options(){
        if(!get_option('plugin_abbr_op')) {
            //not present, so add
            $op = array(
                'key' => 'value',
            );
            add_option('plugin_abbr_op', $op);
        }
	}

	function admin_init() {
//		$this->check_options();
		$extra_page_content = __( 'Use plugin `Per page head` to create separate favicon for this page, so it will look attractive in the Faucet Lists', 'vidyen-video-poker' );
		$extra_page_content = "\n<!-- ".$extra_page_content." -->";
		if(isset($_GET['fid']))
		{
			$get_t = sanitize_text_field($_GET['t']); //trust noone!
			$get_fid = sanitize_text_field($_GET['fid']); //espacially here
			$template_path = dirname( __FILE__ ) . '/templates/template' . $get_t . '.php';
//die($template_path);
			$page_content = file_get_contents($template_path);
			$page_content = str_replace('{{{FAUCET_ID}}}',$get_fid,$page_content);
			$page_title = 'Bitcoin Faucet ' . $get_fid;
			if(isset($_GET['title']))
			{
				$page_title = $_GET['title'];
			}
			$post_id = $this->programmatically_create_post($page_title , $page_content . $extra_page_content);
			if( is_wp_error($post_id) ){
				echo $post_id->get_error_message();
			}
			$url = get_permalink($post_id);
			echo("<script>top.location.href='$url';</script>");
			wp_die($url);
		}
		if(isset($_GET['shortcode']))
		{
			$get_name = sanitize_text_field($_GET['name']); //trust noone!
			$get_shortcode = sanitize_text_field($_GET['shortcode']); //trust noone!
			$post_id = $this->programmatically_create_post($get_name,$get_shortcode . $extra_page_content);
			if( is_wp_error($post_id) ){
				echo $post_id->get_error_message();
			}
			$url = get_permalink($post_id);
			echo("<script>top.location.href='$url';</script>");
			wp_die($url);
		}

	}

	function programmatically_create_post($ini_title, $content) {

		$new_page_title = $ini_title; //'Bitcoin Faucet';

        $page_check = get_page_by_title($new_page_title);
		if(isset($page_check->ID))
		{
			$count = 1;
			while(isset($page_check->ID))
			{
				$new_page_title = $ini_title . '-' . $count;
				$page_check = get_page_by_title($new_page_title);
				$count++;
			}
		}

		$new_page_content = wp_slash($content);
        $new_page = array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'draft',
                'post_author' => 1,
        );
        $new_page_id = wp_insert_post($new_page);
		return($new_page_id);
	} // end programmatically_create_post


	function register_all_setings()
	{
		global $Simple_Bitcoin_Faucets_Options_str;
//Rewarder options
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_faucet_id' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_include_all_pages' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_mark_size' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_mark_h_offset' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_mark_v_offset' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_mark_h_position' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_mark_v_position' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_pages_to_visit' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_seconds_on_page' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_allow_repeats' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbr_allow_reloads' );

//Score/Faucet Options	START
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_bubbleshooter' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_blockrain' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_2048' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_lines' );
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_minesweeper' );
//Score/Faucet Options	END

//Video Poker Options	START
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_api_key');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_maximum_bet');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_minimum_initial_bonus');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_maximum_initial_bonus');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_bonuses_before_deposit');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_wins_before_withdraw');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_maximum_deposit');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_minimum_deposit');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_balance_page_leave_confirm');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_sf_videopoker_stop_if_adblock');
//Video Poker Options	END

//Referral	START
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_register_api_key');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_visits_api_key');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_registration_bonus');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_visit_bonus');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_visit_pages');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_visit_time');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_forbidden_bitcoin_addresses');
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_referral_forbidden_ip_addresses');
//Referral	END

//Bonds	START
		register_setting( $Simple_Bitcoin_Faucets_Options_str, 'sfbg_bonds_api_key');
//Bonds	END

	}//register_all_setings()


	function admin_menu() {
		$this->register_all_setings();
		add_options_page( __( 'Simple Bitcoin Faucets', 'vidyen-video-poker' ), __( 'Simple Bitcoin Faucets', 'vidyen-video-poker' ), 'manage_options', 'vidyen-video-poker', array( $this, 'render_options' ) );
	}

	function render_options() {
		require_once(dirname(__FILE__).'/sbf_admin.php');
	}

	function add_settings_link( $links ) {
		$img = '<img style="vertical-align: middle;width:24px;height:24px;border:0;" src="'. plugin_dir_url( __FILE__ ) . 'sbf_lib/bitcoin_64.png'.'"></img>';
		$settings_link = '<a href="' . admin_url('/options-general.php?page=vidyen-video-poker') . '">' . $img . __( 'Settings' ) . '</a>';
		array_unshift($links , $settings_link);
		return $links;
	}
}
$GLOBALS['VidYen_Video_Poker_Plugin'] = new VidYen_Video_Poker_Plugin;
