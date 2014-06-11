<?php

if ($sessionMsgTone=='danger') echo '</nav>'; // Keep danger messages obtrusive

echo '<div style="display: none" id="session-msg" class="center col-md-3 alert alert-';
echo !empty($sessionMsgTone) ? $sessionMsgTone : 'success';
echo ' alert-dismissable">';
if ($sessionMsgTone=='danger') {
	echo '<button type="button" class="close" area-hidden="true">&times;</button>';
}
// If there is a message to user
if ($sessionMsg) {
	echo '<strong><span id="msgSet">'.$sessionMsg.'</span></strong>';
}
echo '</div>';

if ($sessionMsgTone!='danger') echo '</nav>';