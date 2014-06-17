<?php

header("content-type:application/json");

$sessionMsg = SessionModel::get('msg');
$sessionMsgTone = SessionModel::get('msg-tone');

unset($_SESSION['msg']);
unset($_SESSION['msg-tone']);

$user = SessionModel::get('user');

$config = Config::getConfig();
$admin = $config->get('admin','username');


//REMOVE
$success = 'true';
$sessionMsg = 'testing';
$commentText = 'comment hardcoded in';
$commentCreated = 'hardcoded again';
//REMOVE


$access = ($user) ? 'user' : 'anonymous';
if ($user == $admin) {
	$access = 'admin';
}

$data = array(
	'success' => $success,
	'msg' => '<span id="msgSet"><strong>'.$sessionMsg.'</strong></span>',
	'msgTone' => ($sessionMsgTone) ? $sessionMsgTone : 'success',
	'user' => $user,
	'access' => $access,
	'commentText' => $commentText,
	'commentCreated'=> $commentCreated
);

echo json_encode($data);