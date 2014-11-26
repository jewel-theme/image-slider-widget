<?php

/*-------------------------------------------------------------------------------*/
/*   Frontend Register JS & CSS
/*-------------------------------------------------------------------------------*/
function ewic_reg_script() {
	wp_register_style( 'ewic-cpstyles', plugins_url( 'css/funcstyle.css' , dirname(__FILE__) ), false, EWIC_VERSION, 'all');
	wp_register_style( 'ewic-sldr', plugins_url( 'css/slider.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_style( 'ewic-colorpicker', plugins_url( 'css/colorpicker.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_style( 'ewic-introcss', plugins_url( 'css/introjs.min.css' , dirname(__FILE__) ), false, EWIC_VERSION );
	wp_register_script( 'ewic-colorpickerjs', plugins_url( 'js/colorpicker/colorpicker.js' , dirname(__FILE__) ), false );	
	wp_register_script( 'ewic-eye', plugins_url( 'js/colorpicker/eye.js' , dirname(__FILE__) ), false );
	wp_register_script( 'ewic-utils', plugins_url( 'js/colorpicker/utils.js' , dirname(__FILE__) ), false );
	wp_register_script( 'ewic-introjs', plugins_url( 'js/jquery/intro.min.js' , dirname(__FILE__) ), false );
}
add_action( 'admin_init', 'ewic_reg_script' );

function ewic_frontend_js() {
	wp_register_script( 'ewic-bxslider', plugins_url( 'js/jquery/bxslider/jquery.bxslider.min.js' , dirname(__DIR__) ) );
	wp_register_script( 'ewic-bxslider-easing', plugins_url( 'js/jquery/jquery.easing.1.3.js' , dirname(__DIR__) ) );	
	wp_register_script( 'ewic-prettyphoto', plugins_url( 'js/jquery/prettyphoto/jquery.prettyPhoto.js' , dirname(__DIR__) ) );
}
add_action( 'wp_enqueue_scripts', 'ewic_frontend_js' );

/*-------------------------------------------------------------------------------*/
/*   Generate Slider
/*-------------------------------------------------------------------------------*/	
function ewic_generate_images_slider( $id ) {
	ob_start();
	
	$allimgs = get_post_meta( $id, 'ewic_meta_select_images', true );
	$easing = get_post_meta( $id, 'ewic_meta_settings_effect', true );
	( get_post_meta( $id, 'ewic_meta_slide_auto', true ) == 'on' ) ? $disenauto = 'true' : $disenauto = 'false';
	( get_post_meta( $id, 'ewic_meta_slide_title', true ) == 'on' ) ? $disenttl = 'true' : $disenttl = 'false';
	( get_post_meta( $id, 'ewic_meta_slide_lightbox_autoslide', true ) == 'on' ) ? $disenlbauto = 'true' : $disenlbauto = 'false';
	
	if ( is_array( $allimgs ) ) {
	//Generate HTML Markup	
	echo '<ul  class="bxslider-'.$id.'">';
		foreach( $allimgs as $dat ) {
			$img = wp_get_attachment_image_src( $dat['images'], 'full' );
			if ( $dat['ttl'] ) {
				$isttl = 'title="'.$dat['ttl'].'"';
				}
				else {
					$isttl = '';
					}
			if (get_post_meta( $id, 'ewic_meta_slide_lightbox', true ) == 'on' ) {
				echo'<li class="ewic-slider"><a href="'.$img[0].'" title="'.$dat['ttl'].'" rel="ewicprettyPhoto['.$id.']"><img '.$isttl.' class="ewic-wid-imgs" src="'.$img[0].'" /></a></li>';
				
				} else {
					echo'<li class="ewic-slider"><img '.$isttl.' class="ewic-wid-imgs" src="'.$img[0].'" /></li>';
					}
					
			}
	echo '</ul><br>';		
			
			
	//Generate Slider Script				
	echo '<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".bxslider-'.$id.'").bxSlider({
			slideWidth: 0,
			slideMargin: 10,
			minSlides: 1,
			pager: false,
			useCSS: false,
			easing: "'.$easing.'",
			auto: '.$disenauto.',
			autoControls: true,
			stopAuto: false,
			speed: 2000,
			pause: '.get_post_meta( $id, 'ewic_meta_slide_delay', true ).'000,
			adaptiveHeight: true,
			adaptiveHeightSpeed: 700,
			controls: true,
			preloadImages: "visible",
			infiniteLoop: true,
			captions: '.$disenttl.',
			autoHover: true,
			mode: "'.get_post_meta( $id, 'ewic_meta_slide_style', true ).'", 
			
			onSlideBefore:  function() {
				jQuery(".bxslider-'.$id.' .bx-caption").slideUp();
            },
			onSlideAfter: function() {
				jQuery(".bx-start").trigger("click");
				jQuery(".bxslider-'.$id.' .bx-caption").slideDown();
            }
			
			});
			
			jQuery(".bx-clone a").removeAttr( "rel" );
			
			'.( ( get_post_meta( $id, 'ewic_meta_slide_nav', true ) != 'always' ) ? 'jQuery( ".bxslider-'.$id.'" ).parent().parent().addClass( "navcontroller" );' : '' ).'

			
	jQuery("a[rel^=\'ewicprettyPhoto['.$id.']\']").ewcPhoto({theme: "ewc_default", allow_expand: false, deeplinking: false, slideshow:'.get_post_meta( $id, 'ewic_meta_slide_lightbox_delay', true ).'000, autoplay_slideshow:'.$disenlbauto.', social_tools:false});
			
			
		});
</script>';
		}
		
		$res = ob_get_clean();
		return $res;	
		
}


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


?>