<?php
# Copyright (C) 2009	John Reese
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

class FreenodeIRC extends IRCClient {
	public $name = 'Freenode';

	private function generate_uri() {
		static $s_uri = null;

		if ( !is_null( $s_uri ) ) {
			return $s_uri;
		}

		$t_uri_params = array(
			'nick' => $this->nickname(),
			'channels' => plugin_config_get( 'irc_channel' ),
			'prompt' => 1,
		);

		$s_uri = 'http://webchat.freenode.net/?';
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

	protected function iframe_uri() {
		return $this->generate_uri();
	}

	protected function popup_uri() {
		return $this->generate_uri();
	}
}

