<?php
/*
Plugin Name:       Knoppys Elegant Popup
Plugin URI:        https://www.knoppys.co.uk
Description:       This plugins adds a mailchimp / contact form 7 popup into the front end. 
Version:           2
Author:            Knoppys Digital Limited
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
*/
/***************************
*Load Native & Custom wordpress functionality plugin files. 
****************************/

function knoppys_elegant_popup_scripts(){
	wp_enqueue_script( 'jscookie', plugin_dir_url( __FILE__ ) . '/cookie.js', array(), '1.0.0', true );
}
add_action('wp_enqueue_scripts','knoppys_elegant_popup_scripts');

/*
This is the function that outputs the box
and the contact form.

Please include all the variables for the site. 
*/
function knoppys_elegant_popup(){

	$array = array($_COOKIE['HIDEPOPUP'],$_COOKIE['SIGNEDUP']);	

	if (!in_array('TRUE', $array)) { ?>

	<style type="text/css">
		.popup-container {
			position: fixed;
			z-index: 999999;
			top: 0;
			background: rgba(0,0,0,0.7);
			width: 100%;				
			bottom: 0;
			height: 100%;
			display: none;
		}
		.popup-content {
		    margin-top: 14%
		}
		.popup-content form {
		    max-width: 900px;
		    margin: 0 auto;
		    background: #efefef;
		    border-radius: 10px;
		    padding: 20px;
		}
		div.hideout h3 {
		    float: right;
		    background: red;
		    line-height: 1;
		    padding: 5px;
		    color: #fff;
		    border-radius: 100%;
		    width: 27px;
		    height: 28px;
		    cursor: pointer;
		}
	</style>
	<div class="popup-container">
		<div class="popup-content">
			<center>
				<?php echo do_shortcode(knoppys_variations_popupform(get_host())); ?>					
			</center>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var xSeconds = 6000; // 1 second
			//Show after 6 seconds
			setTimeout(function() {
			   jQuery('.popup-container').fadeIn();				   
			}, xSeconds);

			//Close the popup
			jQuery('div.hideout').on('click', function(){
				jQuery('.popup-container').fadeOut();	
			});

			//Close the popup after the button is clicked
			document.addEventListener( 'wpcf7submit', function( event ) {
			    var xSeconds = 3000; // 1 second
				//Show after 6 seconds
				setTimeout(function() {
				   jQuery('.popup-container').fadeOut();				   
				}, xSeconds);
				//Set the signedup cookie
				jQuery.cookie('SIGNEDUP','TRUE');

			}, false );


			//Set the cookie to keep the popup hidden
			jQuery('div.hideout').bind('click',function(){
				jQuery.cookie('HIDEPOPUP','TRUE', { expires: 1, path: '/' });
			});	
		});
		
	</script>

<?php  } 
			
}
add_action('wp_footer','knoppys_elegant_popup',50);
