<?php


/*-------------------------------------------------------------------------------*/
/*   Frontend Register JS & CSS
/*-------------------------------------------------------------------------------*/
function ewic_reg_script() {
	wp_register_style( 'ewic-pricing-css', plugins_url( 'css/pricing.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_style( 'ewic-cpstyles', plugins_url( 'css/funcstyle.css' , dirname(__FILE__) ), false, EWIC_VERSION, 'all');
	wp_register_style( 'ewic-sldr', plugins_url( 'css/slider.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_style( 'ewic-colorpicker', plugins_url( 'css/colorpicker.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_style( 'ewic-introcss', plugins_url( 'css/introjs.min.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_script( 'ewic-colorpickerjs', plugins_url( 'js/colorpicker/colorpicker.js' , dirname(__FILE__) ), false );	
	wp_register_script( 'ewic-eye', plugins_url( 'js/colorpicker/eye.js' , dirname(__FILE__) ), false );
	wp_register_script( 'ewic-utils', plugins_url( 'js/colorpicker/utils.js' , dirname(__FILE__) ), false );
	wp_register_script( 'ewic-introjs', plugins_url( 'js/jquery/intro.min.js' , dirname(__FILE__) ), false );
	wp_register_style( 'ewic-tinymcecss', plugins_url( 'css/tinymce.css' , dirname(__FILE__) ), false, EWIC_VERSION, 'all');
	wp_register_script( 'ewic-tinymcejs', plugins_url( 'js/tinymce.js' , dirname(__FILE__) ), false );	
		
}
add_action( 'admin_init', 'ewic_reg_script' );

function ewic_frontend_js() {

	wp_register_script( 'ewic-bxslider', EWIC_URL. '/js/jquery/bxslider/jquery.bxslider.min.js' );
	wp_register_script( 'ewic-bxslider-easing', EWIC_URL. '/js/jquery/jquery.easing.1.3.js' );	
	wp_register_script( 'ewic-prettyphoto', EWIC_URL. '/js/jquery/prettyphoto/jquery.prettyPhoto.js' );
	wp_register_style( 'ewic-frontend-css', EWIC_URL. '/css/frontend.css' );
	wp_register_style( 'ewic-bxslider-css', EWIC_URL. '/css/bxslider/jquery.bxslider.css' );
	wp_register_style( 'ewic-prettyphoto-css', EWIC_URL. '/css/prettyphoto/css/prettyPhoto.css' );
	
}
add_action( 'wp_enqueue_scripts', 'ewic_frontend_js' );


/*-------------------------------------------------------------------------------*/
/*   CHECK BROWSER VERSION ( IE ONLY )
/*-------------------------------------------------------------------------------*/
function ewic_check_browser_version_admin( $sid ) {
	
	if ( is_admin() && get_post_type( $sid ) == 'easyimageslider' ){

		preg_match( '/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches );
		if ( count( $matches )>1 ){
			$version = explode(".", $matches[1]);
			switch(true){
				case ( $version[0] <= '8' ):
				$msg = 'ie8';

			break; 
			  
				case ( $version[0] > '8' ):
		  		$msg = 'gah';
			  
			break; 			  

			  default:
			}
			return $msg;
		} else {
			$msg = 'notie';
			return $msg;
			}
	}
}


/*-------------------------------------------------------------------------------*/
/*   AJAX Get Slider List
/*-------------------------------------------------------------------------------*/
function ewic_grab_slider_list_ajax() {
	
	if ( !isset( $_POST['grabslider'] ) ) {
		die('');
		} 
		else {
			
			$list = array();
			
			global $post;
			
			$args = array(
  				'post_type' => 'easyimageslider',
  				'order' => 'ASC',
  				'post_status' => 'publish'
		
				);

				$myposts = get_posts( $args );
				foreach( $myposts as $post ) :	setup_postdata($post);

				$list[$post->ID] = array('val' => $post->ID, 'title' => esc_html(esc_js(the_title(NULL, NULL, FALSE))) );

				endforeach;
				
				}
		
			echo json_encode($list); //Send to Option List ( Array )
			die();


	}

add_action('wp_ajax_ewic_grab_slider_list_ajax', 'ewic_grab_slider_list_ajax');


/*-------------------------------------------------------------------------------*/
/*  Create Upgrade Metabox
/*-------------------------------------------------------------------------------*/
function ewic_upgrade_metabox () {
	$enobuy = '<div style="text-align:center;">';
	$enobuy .= '<a id="ewicprcngtableclr" style="outline: none !important;" target="_blank" href="http://demo.ghozylab.com/plugins/easy-image-slider-plugin/pricing/"><img style="cursor:pointer; margin-top: 7px;" src="'.plugins_url( 'images/buy-now.png' , dirname(__FILE__) ).'" width="241" height="95" alt="Buy Now!" ></a>';
	$enobuy .= '</div>';
echo $enobuy;	
}


/*-------------------------------------------------------------------------------*/
/*  Create Pro Demo Metabox
/*-------------------------------------------------------------------------------*/
function ewic_prodemo_metabox () {
	$enobuy = '<div style="text-align:center;">';
	$enobuy .= '<a id="ewicdemotableclr" style="outline: none !important;" target="_blank" href="http://demo.ghozylab.com/plugins/easy-image-slider-plugin/image-slider-with-thumbnails-at-the-bottom/"><img style="cursor:pointer; margin-top: 7px;" src="'.plugins_url( 'images/view-demo-button.jpg' , dirname(__FILE__) ).'" width="232" height="60" alt="Pro Version Demo" ></a>';
	$enobuy .= '</div>';
echo $enobuy;	
}


/*-------------------------------------------------------------------------------*/
/*   GENERATE SHARE BUTTONS
/*-------------------------------------------------------------------------------*/
function ewic_share() {
?>
<div style="position:relative; margin-top:6px;">
<ul class='ewic-social' id='ewic-cssanime'>
<li class='ewic-facebook'>
<a onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Wordpress Image Slider Plugin&amp;p[summary]=Best Wordpress Image Slider Plugin is powerful and so easy to create image slider in minutes&amp;p[url]=http://demo.ghozylab.com/plugins/easy-image-slider-plugin/&amp;p[images][0]=http://content.ghozylab.com/wp-content/uploads/2014/11/easy-slider-widget-320-200.png', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
</li>
<li class='ewic-twitter'>
<a onclick="window.open('https://twitter.com/share?text=Best Wordpress Image Slider Plugin &url=http://demo.ghozylab.com/plugins/easy-image-slider-plugin/', 'sharer', 'toolbar=0,status=0,width=548,height=325');" title="Twitter" class="circle"><strong>Twitter</strong></a>
</li>
<li class='ewic-googleplus'>
<a onclick="window.open('https://plus.google.com/share?url=http://demo.ghozylab.com/plugins/easy-image-slider-plugin/','','width=415,height=450');"><strong>Google+</strong></a>
</li>
<li class='ewic-pinterest'>
<a onclick="window.open('http://pinterest.com/pin/create/button/?url=http://demo.ghozylab.com/plugins/easy-image-slider-plugin/;media=http://content.ghozylab.com/wp-content/uploads/2014/11/easy-slider-widget-320-200.png;description=Best Wordpress Image Slider Plugin','','width=600,height=300');"><strong>Pinterest</strong></a>
</li>
</ul>
</div>

    <?php
	}


?>