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

form_security_validate( 'plugin_IRC_config_update' );

access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );
auth_reauthenticate();

function maybe_set_option( $name, $value ) {
	if ( $value != plugin_config_get( $name ) ) {
		plugin_config_set( $name, $value );
	}
}

maybe_set_option( 'view_threshold', gpc_get_int( 'view_threshold' ) );
maybe_set_option( 'manage_threshold', gpc_get_int( 'manage_threshold' ) );

maybe_set_option( 'irc_server', gpc_get_string( 'irc_server' ) );
maybe_set_option( 'irc_channel', gpc_get_string( 'irc_channel' ) );
maybe_set_option( 'irc_nick_prefix', gpc_get_string( 'irc_nick_prefix' ) );

maybe_set_option( 'mibbit_settings', gpc_get_string( 'mibbit_settings' ) );
maybe_set_option( 'use_username', gpc_get_bool( 'use_username', OFF ) );
maybe_set_option( 'use_popup', gpc_get_bool( 'use_popup', OFF ) );
maybe_set_option( 'show_motd', gpc_get_bool( 'show_motd', OFF ) );

form_security_purge( 'plugin_IRC_config_update' );
print_successful_redirect( plugin_page( 'config_page', true ) );


