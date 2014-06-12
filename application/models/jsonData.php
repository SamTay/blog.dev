<?php

header("content-type:application/json");

$sessionMsg = SessionModel::get('msg');
$sessionMsgTone = SessionModel::get('msg-tone');

unset($_SESSION['msg']);
unset($_SESSION['msg-tone']);

$user = SessionModel::get('user');

$config = Config::getConfig();
$admin = $config->get('admin','username');

$header = ($user) ? 'user' : 'anonymous';
if ($user == $admin) {
	$header = 'admin';
}


$data = array(
	'success' => $success,
	'msg' => '<span id="msgSet"><strong>'.$sessionMsg.'</strong></span>',
	'msgTone' => ($sessionMsgTone) ? $sessionMsgTone : 'success',
	'user' => $user,
	'headerOptions' => $header
);

echo json_encode($data);