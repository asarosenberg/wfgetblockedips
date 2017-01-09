<?php
/**
 * @package wfgetblockedips
 * @version 1.0
 */
/*
Plugin Name: wfgetblockedips
Plugin URI: n/a
Description: Get IPs currently blocked by Wordfence
Author: asa@wordfence.com
Version: 1.0
Author URI: 
*/

function wfgetblockedips_init() {
	if( class_exists( 'wordfence' ) ) {
 
		add_action( 'network_admin_menu', 'wfgetblockedips_admin_page' );
		add_action( 'admin_menu', 'wfgetblockedips_admin_page' );		
		
		function wfgetblockedips_admin_page() {
			add_menu_page( "Wfgetblockedips", "Wfgetblockedips", 'manage_options', 'wfgetblockedips', 'wfgetblockedips_page' );	
		}		

		function wfgetblockedips_page() {
			
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			
			echo '<div class="wrap">';
			echo '<h1>All IPs currently blocked by Wordfence</h1>';
			
			global $wpdb;
			$wfp_wfBlockedIPLog = $wpdb->base_prefix . 'wfBlocks';
			
			$myrows = $wpdb->get_results( "SELECT IP FROM ".$wfp_wfBlockedIPLog." ORDER BY blockedTime DESC" );
			
			foreach ( $myrows as $row ) {
				$niceip = wfUtils::inet_ntop($row->IP);
				echo $niceip."<br/>";
			}
			
			echo '</div>';
		}
	}
}

add_action( 'plugins_loaded', 'wfgetblockedips_init' );
?>