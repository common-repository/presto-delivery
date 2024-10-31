<?php
/**
 * Plugin Name: Presto Media
 * Plugin URI:       https://wordpress.org/plugins/prestomedia/
 * Description:      Presto Media delivers your assignment directly into your WordPress site automatically for you
 * Version:           1.0.0
 * Author:            Presto Media
 * Author URI:        https://my.presto.media/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prestomedia
 * Domain Path:       /languages
 */
require_once( dirname( __FILE__ ) . '/class-hmac-auth.php' );
require_once( dirname( __FILE__ ) . '/class-presto-media-post-api.php' );
require_once( dirname( __FILE__ ) . '/Options.class.php' );
require_once( dirname( __FILE__ ) . '/class-presto-media-post-publish.php' );
add_action( 'rest_api_init', function () {
	$secret 	= Prestomedia_Options::get_secret();
	$auth 		= new Prestomedia_HMAC_Auth( $secret );
	( new Prestomedia_Post_API( $auth ) )->register_routes();
} );
new Prestomedia_Options();

add_filter('plugin_action_links_'.plugin_basename(__FILE__),'prestomedia_add_action_links' );
function prestomedia_add_action_links ( $links ) {
	 $mylinks = array(
	 	'<a href="' . admin_url( 'options-general.php?page=prestomedia' ) . '">Settings</a>',
	 );
	return array_merge( $links, $mylinks );
}

//admin!@#$%%$#@!
//add_shortcode( 'temp_meta_display','prestomedia_debug_post_meta');
function prestomedia_debug_post_meta(){
	ob_start();
	$new_post_id=3224;
	$meta = get_post_meta($new_post_id); 
	$att=get_attached_media('image',$new_post_id);
	$thepostmeta 	=	get_post_meta( $new_post_id,'thepostmeta',true);
	echo '<pre><code>';
	//print_r( $att);
	//print_r($meta);
	//
	echo $thepostmeta['attachments']['facebookimage'];
	echo $thepostmeta['attachments']['twitterimage'];
	print_r($thepostmeta);

	echo '</code></pre>';

	$o=ob_get_contents();
	ob_end_clean();
	return $o;
	}