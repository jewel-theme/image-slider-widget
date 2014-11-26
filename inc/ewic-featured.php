<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function ewic_featured_init() {
    $ewic_featured_init = add_submenu_page('edit.php?post_type=easyimageslider', 'Featured Plugins', __('Featured Plugins', 'easywic'), 'edit_posts', 'ewic_featured_plugins', 'ewic_featured_page');
}
add_action( 'admin_menu', 'ewic_featured_init' );


function ewic_featured_page() {
	ob_start(); ?>
	<div class="wrap" id="ghozy-featured">
		<h2>
			<?php _e( 'GhozyLab Featured Plugins', 'easywic' ); ?>
		</h2>
		<p><?php _e( 'These plugins available on Lite and Pro version.', 'easywic' ); ?></p>
		<?php echo ewic_get_feed(); ?>
	</div>
	<?php
	echo ob_get_clean();
}


function ewic_get_feed() {
	if ( false === ( $cache = get_transient( 'easysliderwidget_featured_feed' ) ) ) {
		$feed = wp_remote_get( 'http://content.ghozylab.com/feed.php?c=featuredplugins', array( 'sslverify' => false ) );
		if ( ! is_wp_error( $feed ) ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( 'easysliderwidget_featured_feed', $cache, 3600 );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the list from the server. Please try again later.', 'easywic' ) . '</div>';
		}
	}
	return $cache;
}