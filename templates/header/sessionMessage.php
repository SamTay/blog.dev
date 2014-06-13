<?php

echo '<div class="fixedElement col-md-offset-4 col-md-3">';
echo '<div style="display: none" id="session-msg" class="alert alert-';
echo !empty($sessionMsgTone) ? $sessionMsgTone : 'success';
echo ' alert-dismissable">';
if (!empty($sessionMsgTone)) {
	echo '<button type="button" class="close" area-hidden="true">&times;</button>';
}
// If there is a message to user
if ($sessionMsg) {
	echo '<strong><span id="msgSet">'.$sessionMsg.'</span></strong>';
}
echo '</div></div>';