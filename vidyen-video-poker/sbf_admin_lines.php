<?php 
?>

<link rel="stylesheet" href="<?php echo(plugin_dir_url( __FILE__ )) ?>lines/lines.css">   
<script src="<?php echo(plugin_dir_url( __FILE__ )) ?>lines/lines.js"></script>
 <a href="javascript:document.getElementById('lines_hints').scrollIntoView();"><b><?php _e( 'Scroll to Hints', 'vidyen-video-poker' ); ?></b></a>

<hr>
<?php _e( 'Use Shortcode', 'vidyen-video-poker' ); ?>  <code>[SBFG_LINES]</code> 
 <?php _e( 'where you want the game to appear', 'vidyen-video-poker' ); ?> , 
 <?php _e( 'or', 'vidyen-video-poker' ); ?>
 <a href="#" onclick="window.open(top.location.href+'&shortcode=[SBFG_LINES]&name=Lines');return false;"><?php _e('Generate test Page', 'vidyen-video-poker' ); ?></a>

		<hr>
		
<div id="sfbg_ln_settings" style="float: left; padding:10px;">	

		<input sbf_game="lines" type="hidden" id="sbfg_sf_h_lines" name="sfbg_sf_lines" class="sbfg_sf_h_lines sbfg_sf_h" value="<?php echo esc_attr( get_option('sfbg_sf_lines','') ); ?>"></input>
		<div sbf_game="lines" id="sbfg_sf_default_lines" style="display:none" class="sbfg_sf_default sbfg_sf_default_lines">10:123456,50:123456,150:123456,300:123456,450:123456</div>
		<div sbf_game_settings="lines" style="display:none"></div>
		<div id="sbfg_sf_table_lines" class="sbfg_sf_table" >
			<div id="sbfg_sf_table_header_lines" class="sbfg_sf_table_header">
				<div class="sbfg_sf_table_header_field"><?php _e( 'Score', 'vidyen-video-poker' ); ?></div>
				<div class="sbfg_sf_table_header_field"><?php _e( 'Faucet Id', 'vidyen-video-poker' ); ?></div>
			</div>

			<div sbf_game="lines" id="sbfg_sf_current_lines" class="sbfg_sf_current sbfg_sf_current_lines"></div>
		</div>
		<script>
			jQuery(document).ready(function() {
				sbf_sf_parse_from_options('lines',false,true,true);
			});
		</script>
		
		<?php submit_button(); ?>
</div>

<div id="sfbg_ln_example" style="float: left; padding:10px;">
<script>
<?php echo($this->lines_shortcode_localize()); ?>
</script>

<div class="sfbg_ln_game_wrap" style="border:0px dotted gray;">
<div id="sfbg_ln_game" class="sfbg_ln_game" >
	<div id="game">
			<div class="sfbg_ln_score"><?php _e( 'Score', 'vidyen-video-poker' ); ?> : <strong class="score">0</strong></div>
			<div class="forecast sfbg_ln_forecast"></div>
		<div class="grid"></div>		
	</div>
</div>
<div id="sfbg_ln_faucet-TO-BE" style="display:none;width:500px;min-height:400px;"></div></div>

<script src="<?php echo(plugin_dir_url( __FILE__ )) ?>lines/starter.js"></script>
</div>


<div id='lines_hints' style="clear:both;"> 
<hr>
<b><?php _e( 'Hints', 'vidyen-video-poker' ); ?>:</b><br>
&nbsp;-&nbsp;
<?php _e( 'You may use same Faucet as a reward for different scores', 'vidyen-video-poker' ); ?>.
 <?php _e( 'However remember - every Faucet is a link to your page', 'vidyen-video-poker' ); ?>
 <?php _e( 'to bring more users from the Faucet Lists', 'vidyen-video-poker' ); ?>
 <?php _e( 'like', 'vidyen-video-poker' ); ?>
 <a target=_blank href="<?php _e( 'https://wmexp.com/', 'vidyen-video-poker' ); ?>" ><?php _e( 'here', 'vidyen-video-poker' ); ?></a>
 <?php _e( 'and', 'vidyen-video-poker' ); ?>
 <a  target=_blank href="<?php _e( 'https://cryptoo.me/rotator/', 'vidyen-video-poker' ); ?>"><?php _e( 'here', 'vidyen-video-poker' ); ?></a>.


<hr>
</div>
	
	
<script>


</script>		
<?php

?>