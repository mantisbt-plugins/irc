<?php
# Copyright (C) 2008	John Reese
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

class IRCPlugin extends MantisPlugin {
	static $clients;

	/**
	 * Plugin information
	 */
	function register() {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->page = 'config_page';

		$this->version = '0.1';
		$this->requires = array(
			'MantisCore' => '1.2.0',
		);

		$this->author = 'John Reese';
		$this->contact= 'jreese@leetcode.net';
		$this->url= 'http://leetcode.net';
	}

	/**
	 * Load plugin API
	 */
	function init() {
		require_once( config_get_global( 'plugin_path' ) . 'IRC/IRCClient.class.php' );
	}

	/**
	 * Plugin configuration settings
	 */
	function config() {
		return array(
			'view_threshold' => REPORTER,
			'manage_threshold' => ADMINISTRATOR,

			'irc_client' => 'Mibbit',

			'irc_server' => '',
			'irc_channel' => '',
			'irc_nickname' => 'mantisbt_?????',

			'mibbit_settings' => '',
			'use_username' => ON,
			'use_popup' => OFF,
			'show_motd' => OFF,
		);
	}

	/**
	 * Plugin event hooks
	 */
	function hooks() {
		return array(
			'EVENT_MENU_MAIN' => 'menu',
		);
	}

	/**
	 * Show the IRC link.
	 */
	function menu( $p_event ) {
		if ( access_has_global_level( plugin_config_get( 'view_threshold' ) ) ) {
			$t_client = IRCPlugin::client();
			$t_use_popup = plugin_config_get( 'use_popup' );

			if ( $t_client !== null ) {
				return ( $t_use_popup ? $t_client->popup() : '<a href="' . plugin_page( 'irc' ) . '">' . plugin_lang_get( 'irc' ) . '</a>' );
			}
		}
		return array();
	}

	/**
	 * Return the currently selected IRC client.
	 * @return object Preferred IRCClient implementation
	 */
	static function client() {
		$t_clients = IRCPlugin::clients();
		$t_preferred_client = plugin_config_get( 'irc_client' );

		if ( isset( $t_clients[ $t_preferred_client ] ) ) {
			return $t_clients[ $t_preferred_client ];
		} else {
			return null;
		}
	}

	/**
	 * Initialize and catalog available IRC clients
	 * @return array Available IRCClient implementations
	 */
	static function clients() {
		static $s_clients = null;

		# return cached client info
		if ( null !== $s_clients ) {
			return $s_clients;
		}

		$s_clients = array();
		$t_client_path = config_get_global( 'plugin_path' ) . 'IRC/clients/';

		# look for IRCClient implementations in the IRC/clients/ directory.
		if( $t_dir = opendir( $t_client_path ) ) {
			while(( $t_file = readdir( $t_dir ) ) !== false ) {
				if( '.' == $t_file || '..' == $t_file ) {
					continue;
				}

				# make sure the file is properly named to discover the class name
				if( is_file( $t_client_path . $t_file ) && preg_match( '/^([a-zA-Z0-9_]*)\.class\.php$/', $t_file, $t_matches ) ) {
					include_once( $t_client_path . $t_file );
					$t_class = $t_matches[1];

					# make sure the auto-discovered class name exists and subclasses IRCClient
					if ( class_exists( $t_class ) && is_subclass_of( $t_class, 'IRCClient' ) ) {
						$t_client = new $t_class();
						$s_clients[ $t_client->name ] = $t_client;
					}
				}
			}
			closedir( $t_dir );
		}

		return $s_clients;
	}
}
