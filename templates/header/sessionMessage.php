<?php

if ($sessionMsgTone=='danger') echo '</nav>'; // Keep danger messages obtrusive

// If there is a message to user
if ($sessionMsg) { ?>
	<div style="display: none" id="session-msg" class="center col-md-3 alert alert-<?php echo !empty($sessionMsgTone)
		? $sessionMsgTone : 'success';  ?> alert-dismissable">
		<?php if ($sessionMsgTone=='danger') echo '<button type="button" class="close" area-hidden="true">&times;</button>'; ?>
		<strong><?php echo $sessionMsg; ?></strong>
	</div>
<?php }

unset($_SESSION['msg']);
unset($_SESSION['msg-tone']);

if ($sessionMsgTone!='danger') echo '</nav>';