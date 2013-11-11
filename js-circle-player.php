<?php
/*
Plugin Name: Js Circle Player
Plugin URI: http://localhost
Description: Mp3 player with jplayer http://jplayer.org/
Version:  1.0
Author: Prosenjit Manna
Author URI: http://localhost
License: http://opensource.org/licenses/MIT

*/
?>
<?php 
define('JSCIRCLEPLAYER_PLUGIN_VERSION', '1.0');
define('JSCIRCLEPLAYER_BASE_URL', plugins_url('/',__FILE__));
function mp3Variable() {
 echo '<script type="text/javascript"> 
 var circlePlayerDir = "'.JSCIRCLEPLAYER_BASE_URL.'";
 </script>';
	}
function circle_player_shortcode_sources(){
	wp_register_style('circleskin_css',plugin_dir_url( __FILE__ ).'skin/circle.skin/circle.player.css');
	wp_register_script('jquery',plugin_dir_url( __FILE__ ).'js/jquery.min.js');
	wp_register_script('jplayer',plugin_dir_url( __FILE__ ).'js/jquery.jplayer.min.js');
	wp_register_script('jquery_transform',plugin_dir_url( __FILE__ ).'js/jquery.transform.js');
	wp_register_script('jquery_grab',plugin_dir_url( __FILE__ ).'js/jquery.grab.js');
	wp_register_script('mod_css_transform',plugin_dir_url( __FILE__ ).'js/mod.csstransforms.min.js');
	wp_register_script('circle_player',plugin_dir_url( __FILE__ ).'js/circle.player.js');
	
  	wp_enqueue_style('circleskin_css');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jplayer');
	wp_enqueue_script('jquery_transform');
	wp_enqueue_script('jquery_grab');
	wp_enqueue_script('mod_css_transform');
	wp_enqueue_script('circle_player');
	
}
add_action('wp_enqueue_scripts','circle_player_shortcode_sources');
add_action('wp_footer', 'mp3Variable');




function circle_jplayer ($atts,$content = null) {
	extract( shortcode_atts( array(
		'mp3' => 'http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3',
		'align' => 'center',
	
	), $atts ) );
	$ids = uniqid();
	return '
	<script type="text/javascript">
//<![CDATA[

jQuery(document).ready(function(){

	/*
	 * Instance CirclePlayer inside jQuery doc ready
	 * CirclePlayer(jPlayerSelector, media, options)
	 *   jPlayerSelector: String - The css selector of the jPlayer div.
	 *   media: Object - The media object used in jPlayer("setMedia",media).
	 *   options: Object - The jPlayer options.
	 *
	 * Multiple instances must set the cssSelectorAncestor in the jPlayer options. Defaults to "#cp_container_1" in CirclePlayer.
	 *
	 * The CirclePlayer uses the default supplied:"m4a, oga" if not given, which is different from the jPlayer default of supplied:"mp3"
	 * Note that the {wmode:"window"} option is set to ensure playback in Firefox 3.6 with the Flash solution.
	 * However, the OGA format would be used in this case with the HTML solution.
	 */

	var myCirclePlayer = new CirclePlayer("#jquery_jplayer_'.$ids.'",
	{
		mp3: "'.$mp3.'",
	}, {
		cssSelectorAncestor: "#cp_container_'.$ids.'",
		supplied: "mp3",
		swfPath: "'.JSCIRCLEPLAYER_BASE_URL.'/js/Jplayer.swf",
		wmode: "window"
	});
});
//]]>
</script>
	
	
	
		<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. Made by http://www.webhubsolution.com-->
			<div id="jquery_jplayer_'.$ids.'" class="cp-jplayer"></div>

			<!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

			<div id="cp_container_'.$ids.'" class="cp-container '.$align.'">
				<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
					<div class="cp-buffer-1"></div>
					<div class="cp-buffer-2"></div>
				</div>
				<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
					<div class="cp-progress-1"></div>
					<div class="cp-progress-2"></div>
				</div>
				<div class="cp-circle-control"></div>
				<ul class="cp-controls">
					<li><a href="#" class="cp-play" tabindex="1">play</a></li>
					<li><a href="#" class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
				</ul>
			</div>';
	}
add_shortcode( 'audio', 'circle_jplayer' );




?>