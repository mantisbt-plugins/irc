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

access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );
auth_reauthenticate();

html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();

print_manage_menu();

?>

<br/>
<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post">
<?php echo form_security_field( 'plugin_IRC_config_update' ) ?>
<table class="width75" align="center" cellspacing="1">

<tr>
<td class="form-title" colspan="2"><?php echo plugin_lang_get( 'title' ), ': ', plugin_lang_get( 'configuration' ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'view_threshold' ) ?></td>
<td><select name="view_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'view_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'manage_threshold' ) ?></td>
<td><select name="manage_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'manage_threshold' ) ) ?></select></td>
</tr>

<tr class="spacer"><td></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'irc_client' ) ?></td>
<td><select name="irc_client">
	<?php foreach( IRCPlugin::clients() as $name => $client ) {
		echo '<option value="', $name, '" ', ( plugin_config_get( 'irc_client' ) == $name ? 'selected="selected"' : '' ),
			'>', string_display_line( $name ), '</option>';
	} ?>
</select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'irc_server' ) ?></td>
<td><input name="irc_server" value="<?php echo string_attribute( plugin_config_get( 'irc_server' ) ) ?>" size="20"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'irc_channel' ) ?></td>
<td><input name="irc_channel" value="<?php echo string_attribute( plugin_config_get( 'irc_channel' ) ) ?>" size="20"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'irc_nick_prefix' ) ?></td>
<td><input name="irc_nick_prefix" value="<?php echo string_attribute( plugin_config_get( 'irc_nick_prefix' ) ) ?>" size="20"/><br/><?php echo plugin_lang_get( 'irc_nick_prefix_help' ) ?></td>
</tr>

<tr class="spacer"><td></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'mibbit_settings' ) ?></td>
<td><input name="mibbit_settings" value="<?php echo string_attribute( plugin_config_get( 'mibbit_settings' ) ) ?>" size="20"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'options' ) ?></td>
<td>
	<label><input type="checkbox" name="use_username" <?php echo ( plugin_config_get( 'use_username' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'use_username' ) ?></label><br/>
	<label><input type="checkbox" name="use_popup" <?php echo ( plugin_config_get( 'use_popup' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'use_popup' ) ?></label><br/>
	<label><input type="checkbox" name="show_motd" <?php echo ( plugin_config_get( 'show_motd' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'show_motd' ) ?></label><br/>
</td>
</tr>

<tr>
<td class="center" colspan="2"><input type="submit" value="<?php echo plugin_lang_get( 'update' ) ?>"/></td>
</tr>

</table>
</form>

<?php
html_page_bottom1( __FILE__ );


