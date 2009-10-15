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

/**
 * Structure to define a generalized, web-based IRC client.
 */
abstract class IRCClient {

	/**
	 * Unique name for a given IRCClient implementation.
	 */
	public $name = null;

	/**
	 * Function to generate the URI for an iframe client window.
	 * @return string Iframe client URI
	 */
	abstract protected function iframe_uri();

	/**
	 * Function to generate the URI for a popup client window.
	 * @return string Popup client URI
	 */
	abstract protected function popup_uri();

	/**
	 * Generate an HTML link to open the IRC client in a popup window.
	 * @return string Popup link
	 */
	final public function popup() {
		plugin_push_current( 'IRC' );

		$uri = $this->popup_uri();
		$title = plugin_lang_get( 'irc' );

		plugin_pop_current();

		return '<a href="' . $uri . '" target="_blank">' . $title . '</a>';

	}

	/**
	 * Generate an HTML iframe to open the IRC client embedded in another page.
	 * @return string Iframe tag
	 */
	final public function iframe() {
		plugin_push_current( 'IRC' );

		$uri = $this->popup_uri();

		plugin_pop_current();

		return '<iframe width="100%" height="450" scrolling="no" frameborder="0" src="' . $uri . '"></iframe>';
	}
}
