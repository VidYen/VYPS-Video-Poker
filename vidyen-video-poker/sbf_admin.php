<?php
function SBFA_get_per_page_head_text()
{
	$ret = '';
	$action = 'install-plugin';
	$slug = 'per-page-add-to';
	$per_page_head_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => $action,
				'plugin' => $slug			
			),
			admin_url( 'update.php' )
		),
		$action.'_'.$slug
	);
	$per_page_head_link = "[<a target=_blank href='$per_page_head_url'>".__( 'Install', 'vidyen-video-poker' )."</a>]";
	if ( is_plugin_active( 'per-page-add-to/perpagehead.php' ) )
	{
		$per_page_head_link = '';
	} 
//	https://ru.wordpress.org/plugins/per-page-add-to/
	$ret = __( 'The <a target=_blank href="https://wordpress.org/plugins/per-page-add-to/">Per Page Head Plugin</a> will be handy to equip each faucet page with unique favicon and social sharing tags', 'vidyen-video-poker' );
	$ret .= '. ' . $per_page_head_link;
	return $ret;
}

?>


		
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>	
<script>
<?php echo($this->main_js_shortcode_localize()); ?>
var sbf_admin = true;
</script>
<link rel="stylesheet" href="<?php echo(plugin_dir_url( __FILE__ )) ?>sbf_lib/sbf.css"> 
<script src="<?php echo(plugin_dir_url( __FILE__ )) ?>sbf_lib/sbf.js"></script> 

<style>
html {
  scroll-behavior: smooth;
}
#sfbs_intro{
padding: 10px;
border: 2px outset gray;
margin: 10px;
}
.sbf_menu_item{
	display:inline;
	cursor: pointer;
	padding: 2px 10px 2px 10px;
	border-radius: 10px 10px 0px 0px;
	border-color:black;
	border-style: outset;
	background-color: #f9f9f9;
}

.sbf_menu_item_selected
{
	font-size:150%;
	border-left-width: 4px;
	border-top-width: 4px;
	border-right-width: 4px;	
	border-bottom-width: 0px;
	color: black;
}

.sbf_menu_item_unselected
{
	font-size:110%;
	border-left-width: 1px;
	border-top-width: 1px;
	border-right-width: 1px;	
	border-bottom-width: 1px;
	color: blue;
}

#sbf_admin_form{
	background-color: #f9f9f9;
}
</style>
<form id="sbf_admin_form" method="post" action="options.php"> 
<?php 
global $options;
print_r($options); 
global $VidYen_Video_Poker_Options_str;
settings_fields( $VidYen_Video_Poker_Options_str );
do_settings_sections( $VidYen_Video_Poker_Options_str ); 
?>
    <h3><?php _e( 'Simple Bitcoin Faucets', 'vidyen-video-poker' ); ?></h3>
	<div id='sfbs_intro'>
<!--
		<b><?php _e( 'ATT!', 'vidyen-video-poker' ); ?></b>&nbsp;
-->
		<?php _e( 'In order to use this plugin functionality full-scale you will need to be able to use Remoute Faucets', 'vidyen-video-poker' ); ?>.
		<br>
		<?php _e( 'Please', 'vidyen-video-poker' ); ?>
		<a target=_new href="<?php _e('https://wmexp.com/remotely-hosted-bitcoin-faucet-examples-list/example-creating-remote-faucet/', 'vidyen-video-poker' ); ?>"><?php _e('Learn how to create Remote Faucet', 'vidyen-video-poker' ); ?></a> ,
		<a target=_new href="<?php _e('https://wmexp.com/', 'vidyen-video-poker' ); ?>"><?php _e('Visit other Faucets', 'vidyen-video-poker' ); ?></a> ,
		<a target=_new href="<?php _e('https://wmexp.com/remotely-hosted-bitcoin-faucet-examples-list/', 'vidyen-video-poker' ); ?>"><?php _e('See Examples', 'vidyen-video-poker' ); ?></a> ,
		<a target=_new href="<?php _e('https://wmexp.com/remotely-hosted-bitcoin-faucets-faq/', 'vidyen-video-poker' ); ?>"><?php _e('Read FAQ', 'vidyen-video-poker' ); ?></a> .
		<br>
		<?php _e( 'When you are ready, create Remote Faucets in the', 'vidyen-video-poker' ); ?>&nbsp;
		<a target=_new href="https://wmexp.com/my-faucets/?furl=<?php echo(urldecode(get_site_url()));?>"><?php _e('Faucet Manager', 'vidyen-video-poker' ); ?></a>.
		<br>
		<?php _e( 'In the mean time for testing purposes please use Stub Faucet', 'vidyen-video-poker' ); ?> 
		( Faucet ID: <b>123456</b> )
		<br>
		<?php echo(SBFA_get_per_page_head_text()); ?>
		<a style='float:right;' onclick='flip_intro(1)' href='javascript:void(0)'><?php _e( 'Hide Intro', 'vidyen-video-poker' ); ?></a>
	</div> <!-- sfbs_intro -->
		<a id='show_intro' style='float:right;display:none;' onclick='flip_intro(0)' href='javascript:void(0)'><?php _e( 'Show Intro', 'vidyen-video-poker' ); ?></a>
		<script>
		var ls_intro_name = '1.0.13';
		function flip_intro(do_hide) {
			if(do_hide == 1)
			{
				jQuery("#sfbs_intro").hide();
				jQuery("#show_intro").show();
			} else {
				jQuery("#sfbs_intro").show();
				jQuery("#show_intro").hide();			
			}
			localStorage.setItem(ls_intro_name, do_hide);
			return true;
		}
		flip_intro(localStorage.getItem(ls_intro_name));
		</script>
	<br>

<script>	
var sfbs_cur_tab = localStorage.getItem("sfbs_cur_tab");
if(sfbs_cur_tab == null)
{
	sfbs_cur_tab = 'rewarder';
	localStorage.setItem("sfbs_cur_tab",sfbs_cur_tab);	
}
</script>	
	<div class='sbf_menu'>
		<div class='sbf_menu_item sbf_menu_item_selected' id='sbf_m_rewarder' onClick="sfbs_switch_tab('rewarder')">Rewarder</h3></div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_referral' onClick="sfbs_switch_tab('referral')">Referral</h3></div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_bonds' onClick="sfbs_switch_tab('bonds')">Bonds</h3></div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_bubbleshooter' onClick="sfbs_switch_tab('bubbleshooter')">BubbleShooter</div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_2048' onClick="sfbs_switch_tab('2048')">2048</div>		
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_blockrain' onClick="sfbs_switch_tab('blockrain')">BlockRain</div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_lines' onClick="sfbs_switch_tab('lines')">Lines</div>	
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_minesweeper' onClick="sfbs_switch_tab('minesweeper')">Minesweeper</div>		
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_faucets'  onClick="sfbs_switch_tab('faucets')">Faucets</div>
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_videopoker' onClick="sfbs_switch_tab('videopoker')">VideoPoker</h3></div>
<!--		
		<div class='sbf_menu_item sbf_menu_item_unselected' id='sbf_m_more'  onClick="sfbs_switch_tab('more')"><?php _e( 'more', 'vidyen-video-poker' ); ?>...</div>
-->
	</div>
	<hr>
	
	
	<div class='sbf_mb' id='sbf_b_rewarder' >
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_rewarder.php'); 
		?>
	</div>

	<div class='sbf_mb' id='sbf_b_referral' >
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_referral.php'); 
		?>
	</div>	
	
	<div class='sbf_mb' id='sbf_b_bonds' >
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_bonds.php'); 
		?>
	</div>		
	
	<div class='sbf_mb' id='sbf_b_bubbleshooter' >
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_bubbleshooter.php'); 
		?>
	</div>

	<div class='sbf_mb' id='sbf_b_blockrain' >	
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_blockrain.php'); 
		?>
	</div>	
			
	<div class='sbf_mb' id='sbf_b_faucets' >	
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_faucets.php'); 
		?>
	</div>

	<div class='sbf_mb' id='sbf_b_2048' >	
		<?php
		require_once(dirname(__FILE__).'/sbf_admin_2048.php'); 
		?>
	</div>

	<div class='sbf_mb' id='sbf_b_lines' >	
		<?php
		require_once(dirname(__FILE__).'/sbf_admin_lines.php'); 
		?>
	</div>		

	<div class='sbf_mb' id='sbf_b_minesweeper' >	
		<?php
		require_once(dirname(__FILE__).'/sbf_admin_minesweeper.php'); 
		?>
	</div>		

	<div class='sbf_mb' id='sbf_b_videopoker' >
		<?php 
		require_once(dirname(__FILE__).'/sbf_admin_videopoker.php'); 
		?>
	</div>	
	
	<div class='sbf_mb' id='sbf_b_more' >	
		<?php
		require_once(dirname(__FILE__).'/sbf_admin_more.php'); 
		?>
	</div>		

	
</form>
<a target=_blank href=https://wordpress.org/support/plugin/vidyen-video-poker/reviews?rate=5#new-post>
<?php _e( 'Please rate 5 stars if you like this plugin', 'vidyen-video-poker' ); ?></a>.		
		
<script>	

sfbs_switch_tab(sfbs_cur_tab);

function sfbs_switch_tab(sel)//DO NOT RENAME, videoPoker relays on existion
{
	jQuery('div.sbf_menu_item').removeClass('sbf_menu_item_selected').addClass('sbf_menu_item_unselected');
	jQuery('#sbf_m_'+sel).removeClass('sbf_menu_item_unselected').addClass('sbf_menu_item_selected');
	jQuery('.sbf_mb').hide(0,function(){
		jQuery('#sbf_b_'+sel).show(0);
	});	
	localStorage.setItem("sfbs_cur_tab",sel);
	if(sel != 'rewarder')
	{
		jQuery('#wme_sr_mark').hide();
	}
	else
	{
		jQuery('#wme_sr_mark').show();
	}
	var activate_function_name = sel + '_tab_activated';
	if(typeof (window[activate_function_name]) === 'function')
	{
		window[activate_function_name]();
	}
}//sfbs_switch_tab

function sfbs_get_active_tab()
{
	return localStorage.getItem("sfbs_cur_tab");
}

</script>