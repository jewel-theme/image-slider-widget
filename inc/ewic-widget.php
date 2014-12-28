<?php

class ewic_sc_widget extends WP_Widget {

    // Create Widget
    function ewic_sc_widget() {
        parent::WP_Widget(false, $name = 'Easy Slider Widget', array('description' => 'Use this widget to display your images slider.'));
    }

    // Widget Content
    function widget($args, $instance) { 
        extract( $args );
        $ewic_shortcode = strip_tags($instance['ewic_shortcode']);

        ?>
            <div id="latest-box">
                <span class="latest-text">
                <?php
				if ( $ewic_shortcode ) {
					echo do_shortcode( '[espro-slider id="'.$ewic_shortcode.'" iswidget="widget"]' );
					}
				?> 
                </span> <!-- text -->
            </div> <!-- box -->
        <?php
     }

    // Update and save the widget
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['ewic_shortcode'] = $new_instance['ewic_shortcode'];
    return $new_instance;
    }

    // If widget content needs a form
    function form($instance) {
        //widgetform in backend
        $ewic_shortcode = strip_tags($instance['ewic_shortcode']);
        ?>
        <p><label for="<?php echo $this->get_field_id('ewic_shortcode'); ?>">Select your Slider name and hit save button.<br />
    <select id="<?php echo $this->get_field_id('ewic_shortcode'); ?>" name="<?php echo $this->get_field_name('ewic_shortcode'); ?>" >
	<?php 

global $post;
$args = array(
  'post_type' => 'easyimageslider',
  'order' => 'ASC',
  'post_status' => 'publish'
);

$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post);
echo '<option value=' . $post->ID . '' .  selected( $instance["ewic_shortcode"], $post->ID ) . '>' . esc_html( esc_js( the_title(NULL, NULL, FALSE) ) ) . '</option>';
endforeach; 

?>
</select></label></p>
        <?php       
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ewic_sc_widget");'));


?>