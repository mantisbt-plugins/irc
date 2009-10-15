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
		require_once( 'Mibbit.API.php' );
	}

	/**
	 * Plugin configuration settings
	 */
	function config() {
		return array(
			'view_threshold' => REPORTER,
			'manage_threshold' => ADMINISTRATOR,

			'irc_client' => 'mibbit',

			'irc_server' => 'irc.mibbit.net',
			'irc_channel' => '',
			'irc_nick_prefix' => 'mantisbt_?????',

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
			$t_use_popup = plugin_config_get( 'use_popup' );
			return ( $t_use_popup ? irc_popup() : '<a href="' . plugin_page( 'irc' ) . '">' . plugin_lang_get( 'irc' ) . '</a>' );
		} else {
			return array();
		}
	}
}
