<?php

?>
<?php _e( 'Based on <a target=_blank href="https://wmexp.com/remotely-hosted-bitcoin-faucet-examples-list/example-creating-remote-faucet/">Creating Remote Faucet example</a>', 'vidyen-video-poker' ); ?>.
 <a href="javascript:document.getElementById('faucets_hints').scrollIntoView();"><b><?php _e( 'Scroll to Hints', 'vidyen-video-poker' ); ?></b></a>
<hr>	
		<?php _e( 'Enter <b>Faucet ID</b>:', 'vidyen-video-poker' ); ?> 
		<input type="text" id='sfbs_faucet_id' maxlength="10"  value='' autocomplete="on"></input>
		<div id='sfbs_has_shortcode_faucets'>
			<p><?php _e( 'Use Shortcode:', 'vidyen-video-poker' ); ?> <code>[SBFS fid=<span id='sfbs_shortcode'>123456</span>]</code>
			<?php _e( 'where you want the Faucet to appear', 'vidyen-video-poker' ); ?>,
			<?php _e( 'or', 'vidyen-video-poker' ); ?>
			<a href="#" onclick="window.open(top.location.href+'&fid='+jQuery('#sfbs_shortcode').html()+'&t=1');return false;"><?php _e('Generate simple Faucet Page', 'vidyen-video-poker' ); ?></a>
			<hr>
			<h3><?php _e( 'Extra', 'vidyen-video-poker' ); ?></h3>
			<p><a href="#" onclick="window.open(top.location.href+'&fid='+jQuery('#sfbs_shortcode').html()+'&t=2');return false;"><?php _e('Generate simple Faucet Page (narrow content)', 'vidyen-video-poker' ); ?></a>
			<p><a href="#" onclick="window.open(top.location.href+'&fid='+jQuery('#sfbs_shortcode').html()+'&t=3');return false;"><?php _e('Generate simple Faucet Page (extra fixed ads)', 'vidyen-video-poker' ); ?></a>
			<p><a href="#" onclick="window.open(top.location.href+'&fid='+jQuery('#sfbs_shortcode').html()+'&t=4');return false;"><?php _e('Generate simple Faucet Page (narrow content,extra fixed ads)', 'vidyen-video-poker' ); ?></a>				
		</div><!-- sfbs_has_shortcode_faucets -->
		<hr>

<div id='faucets_hints'>
<b><?php _e( 'Hints', 'vidyen-video-poker' ); ?>:</b><br>
&nbsp;-&nbsp;
<?php _e( 'On the WordPress installation you can use as many Faucets as you want', 'vidyen-video-poker' ); ?>.
<hr>&nbsp;-&nbsp;
<?php _e( 'Use', 'vidyen-video-poker' ); ?> 
 <code><?php echo(get_site_url())?></code> 
 <?php _e( 'as Faucet/App ULR for your Faucets', 'vidyen-video-poker' ); ?>.
<hr>
&nbsp;-&nbsp;
<?php _e( 'While configuring real Faucets in the Faucet Manager, come up with attractive Faucet Names', 'vidyen-video-poker' ); ?>
 <?php _e( 'to bring more users from the Faucet Lists', 'vidyen-video-poker' ); ?>,
 <?php _e( 'like', 'vidyen-video-poker' ); ?>
 <a target=_blank href="<?php _e( 'https://wmexp.com/', 'vidyen-video-poker' ); ?>" ><?php _e( 'here', 'vidyen-video-poker' ); ?></a>
 <?php _e( 'and', 'vidyen-video-poker' ); ?>
 <a  target=_blank href="<?php _e( 'https://cryptoo.me/rotator/', 'vidyen-video-poker' ); ?>"><?php _e( 'here', 'vidyen-video-poker' ); ?></a>.
<hr>
&nbsp;-&nbsp;
<?php _e( 'For non-Wordpress pages of your website use the code', 'vidyen-video-poker' ); ?>
 <span id='sfbs_code1'></span>
 <?php _e( 'where you want the Faucet to appear', 'vidyen-video-poker' ); ?>.
<?php 
$t = $this->faucets_shortcode(array(fid => "{THINGIE_TO_REPLACE}"));
$t = trim($t,"\n");
$t = htmlentities($t);
$t = nl2br($t);
echo("<div id='sfbs_e1' style='display:none;'><code>$t</code></div>"); //example of code
?>
<hr>
</div>
	

		
<script>
function sfbs_switch_faucets_init()
{
	var sfbs_cur_fid = localStorage.getItem("cur_fid");
	if(sfbs_cur_fid == null)
	{
		sfbs_cur_fid = '123456';
	}
	jQuery("#sfbs_faucet_id").val(sfbs_cur_fid).select();
	jQuery("#sfbs_faucet_id").on('change keyup paste', function () {
		var s = jQuery(this).val()
		var n = s.replace(/[^0-9]/g,'');
		jQuery(this).val(n);	
		if(n.length == 0)
		{
			jQuery("#sfbs_has_shortcode_faucets").css('display','none');
		}
		else
		{
			jQuery("#sfbs_has_shortcode_faucets").css('display','block');
			jQuery("#sfbs_shortcode").html(n);
		jQuery('#sfbs_code1').html(jQuery('#sfbs_e1').html().replace(/{THINGIE_TO_REPLACE}/g,n) );				
			localStorage.setItem("cur_fid",n);
		}
	});
}//sfbs_switch_faucets_init
sfbs_switch_faucets_init();
jQuery('#sfbs_faucet_id').trigger('change');
</script>