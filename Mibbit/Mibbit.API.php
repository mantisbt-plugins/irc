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

	$t_uri_params = array(
		'server' => plugin_config_get( 'irc_server', 'Mibbit' ),
		'channel' => plugin_config_get( 'irc_channel', 'Mibbit' ),
		'nick' => plugin_config_get( 'irc_nick_prefix', 'Mibbit' ),
		'settings' => plugin_config_get( 'mibbit_settings', 'Mibbit' ),
		'noServerMotd' => ( plugin_config_get( 'show_motd', 'Mibbit' ) ? 'false' : 'true' ),
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
function mibbit_iframe() {
	$t_uri = mibbit_generate_uri();

	return '<iframe width="600" height="380" scrolling="no" frameborder="0" src="' . $t_uri . '"></iframe>';
}

/**
 * Generate the HTML for a popup widget.
 * @return string HTML
 */
function mibbit_popup( $p_title=null ) {
	$t_uri = mibbit_generate_uri();

	if ( is_null( $p_title ) ) {
		$p_title = plugin_lang_get( 'irc', 'Mibbit' );
	}

	return '<a href="' . $t_uri . '" target="_blank">' . $p_title . '</a>';
}

