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

access_ensure_global_level( plugin_config_get( 'view_threshold' ) );

html_page_top1( plugin_lang_get( 'irc' ) );
html_page_top2();
?>

<br/>
<table class="width75" cellspacing="1" align="center">

<tr>
<td class="form-title"><?php echo plugin_lang_get( 'irc' ) ?></td>
<td class="right"><?php echo irc_popup( plugin_lang_get( 'use_popup' ) ) ?></td>
</tr>

<tr>
<td class="center" colspan="2">

<?php echo irc_iframe() ?>

</td>
</tr>

</table>

<?php
html_page_bottom1( __FILE__ );

