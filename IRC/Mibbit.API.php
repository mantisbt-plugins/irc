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

/**
 * Generate a URI to Mibbit based on current configurations.
 * @return string Mibbit URI
 */
function mibbit_generate_uri() {
	static $s_uri = null;

	if ( !is_null( $s_uri ) ) {
		return $s_uri;
	}

	if ( plugin_config_get( 'use_username', 'IRC' ) && !current_user_is_anonymous() ) {
		$t_nick = user_get_field( auth_get_current_user_id(), 'username' );
	} else {
		$t_nick = plugin_config_get( 'irc_nick_prefix', 'IRC' );
	}

	$t_uri_params = array(
		'server' => plugin_config_get( 'irc_server', 'IRC' ),
		'channel' => plugin_config_get( 'irc_channel', 'IRC' ),
		'nick' => $t_nick,
		'settings' => plugin_config_get( 'mibbit_settings', 'IRC' ),
		'noServerMotd' => ( plugin_config_get( 'show_motd', 'IRC' ) ? 'false' : 'true' ),
	);

	$s_uri = 'http://widget.mibbit.com/?';
	$t_first = true;

	foreach( $t_uri_params as $key => $value ) {
		if ( !empty( $value ) ) {
			$value = rawurlencode( $value );
			$s_uri .= ( $t_first ? "${key}=${value}" : "&${key}=${value}" );
			$t_first = false;
		}
	}

	return $s_uri;
}

/**
 * Generate the HTML for an iframe widget.
 * @return string HTML
 */
function irc_iframe() {
	$t_uri = mibbit_generate_uri();

	return '<iframe width="100%" height="450" scrolling="no" frameborder="0" src="' . $t_uri . '"></iframe>';
}

/**
 * Generate the HTML for a popup widget.
 * @return string HTML
 */
function irc_popup( $p_title=null ) {
	$t_uri = mibbit_generate_uri();

	if ( is_null( $p_title ) ) {
		$p_title = plugin_lang_get( 'irc', 'IRC' );
	}

	return '<a href="' . $t_uri . '" target="_blank">' . $p_title . '</a>';
}

