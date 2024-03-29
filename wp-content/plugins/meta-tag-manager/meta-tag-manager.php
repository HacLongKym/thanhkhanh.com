<?php
/*
Plugin Name: Meta Tag Manager
Plugin URI: https://wordpress.org/plugins/meta-tag-manager/
Description: A simple plugin to manage meta tags that appear on aread of your site or individual posts. This can be used for verifiying google, yahoo, and more.
Author: Marcus Sykes
Version: 2.0.2
Author URI: http://msyk.es/?utm_source=meta-tag-manager&utm_medium=plugin-header&utm_campaign=plugins
Text Domain: meta-tag-manager
*/
/*
Copyright (C) 2016 Marcus Sykes

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
if( !defined('ABSPATH') ) exit;

define('MTM_VERSION', '2.0');

class Meta_Tag_Manager {
	/** loads the plugin */
	public static function init() {
		//include MTM_Tag class
		include('mtm-tag.php');
		// Include admin backend if needed
		if ( is_admin() ) {
			require_once ( 'meta-tag-manager-admin.php' );
		}
		add_action ('wp_head', 'Meta_Tag_Manager::head', 1);
	}
	
	/** puts the meta tags in the head */
	public static function head() {
		//If options form has been submitted, create a $_POST value that will be saved on databse
		$meta_tags = array();
		//check global tags and filter out ones we'll show for this page
		foreach( self::get_data() as $tag ){
			if( !empty($tag->context) ){ //if empty, we assume it's meant to be output everywhere
				foreach( $tag->context as $context ){
					if( $context == 'home' && ( is_home() || is_front_page() ) ){
						$meta_tags[] = $tag;
						continue; //match found, quit the loop
					}else{
						//check post types and taxonomies
						if( preg_match('/^post-type_/', $context) ){
							$post_type = str_replace('post-type_', '', $context);
							if( is_single() && get_post_type() == $post_type ){
								$meta_tags[] = $tag;
							}
							continue; //match found, quit the loop
						}elseif( preg_match('/^taxonomy_/', $context) ){
							$taxonomy = str_replace('taxonomy_', '', $context);
							if( is_tax( $taxonomy ) || ($taxonomy == 'category' && is_category()) || ($taxonomy == 'post_tag' && is_tag()) ){
								$meta_tags[] = $tag;
							}
							continue; //match found, quit the loop
						}
					}
				}
			}else{
				$meta_tags[] = $tag;
			}
		}
		//check individual post in case we have specific post meta tags to show
		if( is_single() || is_page() ){
			$mtm_custom = get_option('mtm_custom');
			if( !empty($mtm_custom['post-types']) && in_array(get_post_type(), $mtm_custom['post-types']) ){
				$meta_tags = array_merge($meta_tags, self::get_post_data());
			}
		}
		//output the filtered out tags that pass validation
		if( !empty($meta_tags) ){
			//add as keys to prevent duplicates
			$meta_tag_strings = array();
			foreach( $meta_tags as $tag ){
				//only output valid keys
				if( $tag->is_valid() ){
					$meta_tag_strings[$tag->output()] = 1;
				}
			}
			//output tags if there are any
			if( !empty($meta_tag_strings) ){
				echo "\r\n\t".'<!-- Meta Tag Manager -->';
				foreach( $meta_tag_strings as $tag_string => $v ){
					echo "\r\n\t".$tag_string;
				}
				echo "\r\n\t".'<!-- / Meta Tag Manager -->';
				echo "\r\n";
			}
		}
	}
	
	public static function get_data(){
		$mtm_data = get_option('mtm_data');
		$meta_tags = array();
		if( is_array($mtm_data) ){
			foreach( $mtm_data as $meta_tag_data ){
				$meta_tags[] = new MTM_Tag($meta_tag_data);
			}
		}
		return $meta_tags;
	}
	
	public static function get_post_data( $post_id = false ){
		if( empty($post_id) ) $post_id = get_the_ID();
		$meta_tag_data = maybe_unserialize(get_post_meta($post_id, 'mtm_data', true));
		$meta_tags = array();
		if( is_array($meta_tag_data) ){
			foreach( $meta_tag_data as $tag_data ){
				$meta_tags[] = new MTM_Tag($tag_data);
			}
		}
		return $meta_tags;
	}
}
// Start this plugin once all other plugins are fully loaded
add_action( 'plugins_loaded', array('Meta_Tag_Manager', 'init'), 100 );

// FREEMIUS INSIGHTS integration
function meta_tag_manager_freemius() {
	global $meta_tag_manager_freemius;
	if ( ! isset( $meta_tag_manager_freemius ) ) {
		// Include Freemius SDK.
		require_once dirname(__FILE__) . '/freemius/start.php';
		$meta_tag_manager_freemius = fs_dynamic_init( array(
			'id'                => '264',
			'slug'              => 'meta-tag-manager',
			'public_key'        => 'pk_07d443985f85078e1d30b59ac31b3',
			'is_premium'        => false,
			'has_addons'        => false,
			'has_paid_plans'    => false,
			'menu'              => array(
				'slug'       => 'meta-tag-manager',
				'account'    => false,
				'contact'    => false,
				'support'    => false,
				'parent'     => array(
					'slug' => 'options-general.php',
				),
			),
		));
	}
	return $meta_tag_manager_freemius;
}
// Init Freemius.
$mtm_freemius_strings = array(
	'you-are-step-away' => __( 'Welcome to the new and improved Meta Tag Manager 2. %s', 'meta-tag-manager' ),
	'activate-x-now' => __('Start setting it up!', 'meta-tag-manager'),
	'optin-x-now' => __( 'Check it out!', 'meta-tag-manager' ),
	'connect-message' => '<br />'. sprintf(__( 'Please help us improve %s by allowing us to collect some information about your site, which is sent to %s.', 'meta-tag-manager' ), '<b>'.__('Meta Tag Manager','meta-tag-manager').'</b>', '<a href="http://freemius.com" target="_blank">freemius.com</a>').
						'<br /><br /><b>' . __('This is totally optional and you can skip this step below!', 'meta-tag-manager').'</b>'
);
$mtm_freemius_strings['connect-message_on-update'] = $mtm_freemius_strings['connect-message'];
$mtm_freemius_strings['few-plugin-tweaks'] = $mtm_freemius_strings['you-are-step-away'];
meta_tag_manager_freemius()->override_i18n($mtm_freemius_strings);