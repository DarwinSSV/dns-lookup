<?php
/*
Plugin Name: DNS Lookup
Description: This plugin displays site's DNS details ( Domain Provider, A Record, Domain Expiration ) in WP admin dashboard widget. Also send notification to admin on domain expiration.
Author: Darwin S
Author URI: http://darwins.unaux.com
Version: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if( !defined( 'ABSPATH' ) ) {
	die();
}

define( 'AUTH_URI', 'https://linkedin.com/in/darwin-s' );


if( !class_exists( 'DNS_LOOKUP' ) ) {
	class DNS_LOOKUP {
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'display_dns_details' ] );
		}

		public function display_dns_details() {

			require_once( 'data/api.php' );
		} 
	}
	new DNS_LOOKUP();
}
